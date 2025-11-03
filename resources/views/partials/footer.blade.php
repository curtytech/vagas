<footer class="border-t border-neutral-200 dark:border-neutral-800 mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8 text-sm flex flex-col md:flex-row gap-4 md:gap-0 md:items-center md:justify-between">
        <div>&copy; {{ date('Y') }} <a href="https://phelipecurty.vercel.app" target="_blank" class="hover:text-amber-600 dark:hover:text-amber-500">Phelipe Curty</a></div>
        <div class="flex gap-4">
            <a href="/" class="hover:text-amber-600 dark:hover:text-amber-500">Início</a>
            <a href="{{ url('/admin') }}" class="hover:text-amber-600 dark:hover:text-amber-500">Painel</a>
        </div>
    </div>
</footer>