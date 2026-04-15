<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-vibrant w-full justify-center text-sm py-3 tracking-[0.12em] focus:ring-4 focus:ring-indigo-200']) }}>
    {{ $slot }}
</button>
