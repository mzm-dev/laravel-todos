<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center gap-2 whitespace-nowrap px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
