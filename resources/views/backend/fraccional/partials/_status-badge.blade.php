@php
    $map = [
        'pending'      => ['bg' => 'bg-yellow-100',  'text' => 'text-yellow-800', 'label' => 'Pendiente'],
        'accepted'     => ['bg' => 'bg-blue-100',    'text' => 'text-blue-800',   'label' => 'Aceptada'],
        'negotiating'  => ['bg' => 'bg-indigo-100',  'text' => 'text-indigo-800', 'label' => 'Negociando'],
        'proposed'     => ['bg' => 'bg-purple-100',  'text' => 'text-purple-800', 'label' => 'Términos propuestos'],
        'confirmed'    => ['bg' => 'bg-pink-100',    'text' => 'text-pink-800',   'label' => 'Esperando pago'],
        'active'       => ['bg' => 'bg-green-100',   'text' => 'text-green-800',  'label' => 'Activo'],
        'completed'    => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800','label' => 'Completado'],
        'rejected'     => ['bg' => 'bg-red-100',     'text' => 'text-red-800',    'label' => 'Rechazada'],
        'cancelled'    => ['bg' => 'bg-gray-100',    'text' => 'text-gray-600',   'label' => 'Cancelada'],
    ];
    $s = $map[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => ucfirst($status)];
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $s['bg'] }} {{ $s['text'] }}">
    @if($status === 'active')
        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
    @endif
    {{ $s['label'] }}
</span>