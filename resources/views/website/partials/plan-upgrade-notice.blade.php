@php
    $serviceLabel = $serviceLabel ?? 'this';
    $userId = $userId ?? (Auth::id() ?? 0);
    $title = $title ?? ('Your current plan does not include ' . $serviceLabel . ' service.');
    $subtitle = $subtitle ?? 'Please upgrade your plan to continue, or contact us for help.';
@endphp
<div class="plan-upgrade-notice mb-4 p-4" style="border:1px solid #f5c2c7;background:#fff5f5;border-radius:10px;">
    <p class="mb-2 text-danger" style="font-weight:600;">{{ $title }}</p>
    <p class="mb-3 text-muted" style="font-size:14px;">{{ $subtitle }}</p>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-apply btn-apply-big hover-up"
            href="{{ route('pricing', ['user_id' => $userId]) }}">Upgrade Plan</a>
        <a class="btn btn-border hover-up" href="{{ route('contact') }}">Contact Us</a>
    </div>
</div>
