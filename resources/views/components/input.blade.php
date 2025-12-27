@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' =>
        'w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy shadow-sm
         placeholder:text-cinema3-navy/40 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30
         disabled:opacity-60'
    ]) !!}>
