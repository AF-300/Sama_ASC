@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-or-sable text-sm font-display font-medium leading-5 text-blanc-sable focus:outline-none focus:border-or-sable transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-display font-medium leading-5 text-blanc-sable/60 hover:text-blanc-sable hover:border-blanc-sable/30 focus:outline-none focus:text-blanc-sable focus:border-blanc-sable/30 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>