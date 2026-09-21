{{-- Reusable College page banner. Use @component for action slot, or @include without actions. --}}
@php
    $emoji = $emoji ?? '📌';
    $title = $title ?? 'Page';
    $subtitle = $subtitle ?? '';
    $crumbs = $crumbs ?? [];
    $illustration = $illustration ?? 'default';
    $slotHtml = isset($slot) ? trim((string) $slot) : '';
@endphp
<div class="zp-page-banner zp-banner-{{ $illustration }}">
    <div class="zp-page-banner-bg" aria-hidden="true">
        <span class="zp-orb zp-orb-1"></span>
        <span class="zp-orb zp-orb-2"></span>
        <span class="zp-grid"></span>
    </div>
    <div class="zp-page-banner-inner">
        <div class="zp-page-banner-copy">
            <div class="zp-page-banner-badge">{{ $emoji }} {{ $title }}</div>
            <h1>{{ $title }}</h1>
            @if($subtitle)
                <p>{{ $subtitle }}</p>
            @endif
            @if(!empty($crumbs))
                <nav class="zp-breadcrumb" aria-label="Breadcrumb">
                    @foreach($crumbs as $i => $crumb)
                        @if($i > 0)<span class="zp-bc-sep">›</span>@endif
                        @if(!empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                        @else
                            <span>{{ $crumb['label'] }}</span>
                        @endif
                    @endforeach
                </nav>
            @endif
        </div>
        <div class="zp-page-banner-right">
            <div class="zp-page-illu zp-illu-{{ $illustration }} d-none d-md-flex" aria-hidden="true">
                @include('admin.layout.partials.college-illustrations', ['type' => $illustration])
            </div>
            @if($slotHtml !== '')
                <div class="zp-page-banner-actions">
                    {!! $slot !!}
                </div>
            @endif
        </div>
    </div>
</div>
