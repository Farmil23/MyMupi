<button {{ $attributes->merge(['type' => 'submit', 'class' =>
    'inline-flex items-center justify-center rounded-xl bg-cinema3-navy px-4 py-2 text-sm font-semibold
     text-cinema3-gold shadow-sm hover:bg-cinema3-navySoft focus:outline-none focus:ring-2
     focus:ring-cinema3-gold/40 transition disabled:opacity-50'
]) }}>
    {{ $slot }}
</button>
