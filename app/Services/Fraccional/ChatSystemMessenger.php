<?php
namespace App\Services\Fraccional;

use App\Models\Fraccional\{Engagement, Message};

class ChatSystemMessenger
{
    public static function post(Engagement $engagement, string $event, array $meta = []): ?Message
    {
        if (!$engagement->conversation) return null;

        $body = match($event) {
            'professional_signed' => '✅ El profesional firmó el contrato.',
            'company_signed'      => '✅ La empresa firmó y aceptó los términos.',
            'contract_proposed'   => '📄 Se propusieron nuevos términos de contrato.',
            'payment_completed'   => '💳 El pago fue completado. El servicio está activo.',
            'service_released'    => '🎉 El servicio fue marcado como completado y los fondos fueron liberados al profesional.',
            'time_entry_added' => sprintf(
                '⏱️ %s cargó %s horas trabajadas el %s. La empresa tiene 72hs para aprobarlas.',
                $meta['professional_name'] ?? 'El profesional',
                number_format($meta['hours'] ?? 0, 2),
                $meta['worked_on'] ?? 'hoy'
            ),

            'time_entry_approved' => sprintf(
                '✅ La empresa aprobó %s horas trabajadas el %s.',
                number_format($meta['hours'] ?? 0, 2),
                $meta['worked_on'] ?? ''
            ),

            'time_entry_auto_approved' => sprintf(
                '⏰ Pasaron 72hs sin respuesta. Se aprobaron automáticamente %s horas del %s.',
                number_format($meta['hours'] ?? 0, 2),
                $meta['worked_on'] ?? ''
            ),

            'time_entry_disputed' => sprintf(
                '⚠️ La empresa inició un reclamo sobre %s horas del %s. Motivo: %s',
                number_format($meta['hours'] ?? 0, 2),
                $meta['worked_on'] ?? '',
                $meta['reason'] ?? 'no especificado'
            ),
            'evidence_submitted' => sprintf(
                '📎 La empresa subió evidencia (%s archivos) sobre las %s horas del %s.',
                $meta['files_count'] ?? 0,
                number_format($meta['hours'] ?? 0, 2),
                $meta['worked_on'] ?? ''
            ),

            'evidence_accepted' => sprintf(
                '🤝 El profesional aceptó la evidencia. Las %s horas no se cobrarán.',
                number_format($meta['hours'] ?? 0, 2)
            ),

            'mediation_started' =>
                '⚖️ El profesional rechazó la evidencia. El caso pasó a mediación de Pipol.',

            'mediation_resolved' => match($meta['outcome'] ?? '') {
                'company' => sprintf(
                    '⚖️ Pipol resolvió a favor de la empresa: las %s horas no se cobrarán.',
                    number_format($meta['total_hours'] ?? 0, 2)
                ),
                'professional' => sprintf(
                    '⚖️ Pipol resolvió a favor del profesional: se aprobaron las %s horas completas.',
                    number_format($meta['total_hours'] ?? 0, 2)
                ),
                'partial' => sprintf(
                    '⚖️ Pipol resolvió parcialmente: %s de %s horas aprobadas.',
                    number_format($meta['approved_hours'] ?? 0, 2),
                    number_format($meta['total_hours'] ?? 0, 2)
                ),
                default => '⚖️ Mediación resuelta.',
            },

            'partial_release' => sprintf(
                '💰 Se liberó pago parcial al profesional: %s %s. Monto retenido: %s %s.',
                number_format($meta['released'] ?? 0, 2),
                $meta['currency'] ?? 'USD',
                number_format($meta['retained'] ?? 0, 2),
                $meta['currency'] ?? 'USD'
            ),
            'refund_issued' => sprintf(
                '↩️ La empresa solicitó devolución del pago. Reembolsados %s %s.',
                number_format($meta['amount'] ?? 0, 2),
                $meta['currency'] ?? 'USD'
            ),
            'counter_proposed' => sprintf(
                '🔄 El profesional envió una contra-propuesta (v%d). Revisá los nuevos términos.',
                $meta['version'] ?? 2
            ),

            'company_revised_proposal' => sprintf(
                '📝 La empresa revisó la propuesta y envió la versión %d.',
                $meta['version'] ?? 2
            ),

            default => $meta['body'] ?? 'Evento del sistema',
        };

        $message = $engagement->conversation->messages()->create([
            'sender_id' => null,
            'type'      => 'system',
            'body'      => $body,
            'meta'      => array_merge(['event' => $event], $meta),
        ]);

        $engagement->conversation->update(['last_message_at' => now()]);

        return $message;
    }
}