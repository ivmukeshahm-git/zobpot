{{-- Clear Boxicons for college page banners (works on light grey) --}}
@php
    $type = $type ?? 'default';
    $icons = [
        'staff' => 'bx-group',
        'students' => 'bx-user',
        'marks' => 'bx-bar-chart-alt-2',
        'history' => 'bx-history',
        'grade' => 'bx-medal',
        'settings' => 'bx-cog',
        'opportunity' => 'bx-briefcase',
        'roles' => 'bx-shield-quarter',
        'default' => 'bx-home-smile',
    ];
    $icon = $icons[$type] ?? $icons['default'];
@endphp
<i class="bx {{ $icon }} zp-page-illu-icon"></i>
