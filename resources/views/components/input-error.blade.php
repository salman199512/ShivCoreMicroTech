@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'mt-2 space-y-1 text-sm text-red-600']) }}>
        @foreach ((array) $messages as $message)
            <li class="rounded-2xl bg-red-50/90 px-3 py-2">{{ $message }}</li>
        @endforeach
    </ul>
@endif
