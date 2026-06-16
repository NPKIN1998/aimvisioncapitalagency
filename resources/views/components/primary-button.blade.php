<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center justify-center px-6 py-3 bg-primary text-primary-foreground 
               font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl 
               hover:brightness-110 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring 
               active:scale-[0.97] disabled:opacity-60 disabled:pointer-events-none 
               transition-all duration-200 ease-in-out'
]) }}>
    {{ $slot }}
</button>