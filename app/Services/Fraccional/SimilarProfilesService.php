<?php
namespace App\Services\Fraccional;

use App\Models\Fraccional\{Diagnostic, Engagement};
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SimilarProfilesService
{
    /**
     * Devuelve un array de criterios + perfiles candidatos.
     * Filtra y rankea profesionales en DB usando un análisis de la IA.
     */
    public function findSimilar(Engagement $previousEngagement, array $newInput): array
    {
        $diagnostic = $previousEngagement->diagnostic;
        $previousProfessional = $previousEngagement->professional;

        // 1. Pedirle a la IA que devuelva criterios estructurados
        $criteria = $this->extractCriteriaWithAI($diagnostic, $previousProfessional, $newInput);

        // 2. Aplicar criterios sobre la DB
        $query = User::where('role', 'fraccional_professional')
            ->where('active', true)
            ->where('id', '!=', $previousProfessional->id); // excluir al anterior

        if (!empty($criteria['min_seniority'])) {
            $query->whereIn('seniority', $criteria['min_seniority']);
        }

        if (!empty($criteria['max_hourly_rate'])) {
            $query->where('hourly_rate', '<=', $criteria['max_hourly_rate']);
        }

        if (!empty($criteria['min_years'])) {
            $query->where('years_of_experience', '>=', $criteria['min_years']);
        }

        if (!empty($criteria['sectors'])) {
            $query->where(function ($q) use ($criteria) {
                foreach ($criteria['sectors'] as $sector) {
                    $q->orWhere('sectors', 'like', "%{$sector}%");
                }
            });
        }

        $profiles = $query->orderByDesc('average_rating')
            ->orderBy('hourly_rate')
            ->limit(12)
            ->get();

        return [
            'criteria' => $criteria,
            'profiles' => $profiles,
            'reasoning' => $criteria['reasoning'] ?? null,
        ];
    }

    /**
     * Llama a Gemini con el contexto completo.
     */
    protected function extractCriteriaWithAI($diagnostic, $previousPro, array $newInput): array
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return $this->fallbackCriteria($newInput);
        }

        $prompt = $this->buildPrompt($diagnostic, $previousPro, $newInput);

        try {
            $response = Http::timeout(15)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent?key={$apiKey}",
                [
                    'contents' => [['parts' => [['text' => $prompt]]]],
                    'generationConfig' => ['responseMimeType' => 'application/json'],
                ]
            );

            $text = $response->json('candidates.0.content.parts.0.text');
            $parsed = json_decode($text, true);

            return $parsed ?: $this->fallbackCriteria($newInput);
        } catch (\Throwable $e) {
            Log::warning('SimilarProfilesService AI failed: ' . $e->getMessage());
            return $this->fallbackCriteria($newInput);
        }
    }

    protected function buildPrompt($diagnostic, $previousPro, array $newInput): string
    {
        $previous = $diagnostic ? json_encode([
            'problema'  => $diagnostic->problem,
            'industria' => $diagnostic->industry,
            'tamaño'    => $diagnostic->size,
            'urgencia'  => $diagnostic->urgency,
            'etapa'     => $diagnostic->stage,
            'rol_recomendado' => $diagnostic->ai_role,
        ], JSON_UNESCAPED_UNICODE) : '{}';

        $previousProInfo = json_encode([
            'profession'  => $previousPro->profession,
            'seniority'   => $previousPro->seniority,
            'hourly_rate' => $previousPro->hourly_rate,
            'years'       => $previousPro->years_of_experience,
        ], JSON_UNESCAPED_UNICODE);

        $newInputJson = json_encode($newInput, JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
Eres un consultor experto en matching de talento fraccional. Una empresa contrató un profesional pero quiere buscar otro perfil similar (con ajustes).

DIAGNÓSTICO ORIGINAL:
{$previous}

PROFESIONAL ANTERIOR:
{$previousProInfo}

NUEVO INPUT DE LA EMPRESA (ajustes que quiere):
{$newInputJson}

Devuelve EXCLUSIVAMENTE un JSON válido con esta estructura. No uses markdown ni texto adicional:
{
    "min_seniority": ["junior", "semi-senior", "senior"] o null,
    "max_hourly_rate": número o null (en USD),
    "min_years": número o null,
    "sectors": ["sector1", "sector2"] o null,
    "reasoning": "Explicación breve (1-2 oraciones) de por qué estos criterios"
}

Reglas:
- Si pidió "más senior" → "min_seniority": ["senior"], y subir min_years a 8+
- Si pidió "más económico" → "max_hourly_rate" un 20-30% menor al del anterior
- Si pidió "perfil similar" → mantener la misma seniority y rango de tarifa similar
- Si menciona industria específica → poner en "sectors"
- "reasoning" es para mostrar al usuario, sé claro y útil
PROMPT;
    }

    protected function fallbackCriteria(array $newInput): array
    {
        // Si la IA falla, devolver criterios mínimos
        return [
            'min_seniority' => null,
            'max_hourly_rate' => null,
            'min_years' => null,
            'sectors' => null,
            'reasoning' => 'No pudimos analizar tu pedido con IA. Te mostramos perfiles similares al anterior.',
        ];
    }
}