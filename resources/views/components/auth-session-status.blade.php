@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 rounded-3xl border border-emerald-200/70 bg-emerald-50/70 px-4 py-3 text-sm text-emerald-700 shadow-sm']) }}>
        {{ $status }}
    </div>
@endif
