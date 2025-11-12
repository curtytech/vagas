<footer class="border-t border-neutral-200 ">
    <div class="max-w-7xl mx-auto px-4 py-8 text-sm flex flex-col md:flex-row gap-4 md:gap-0 md:items-center md:justify-between">
        <div>&copy; {{ date('Y') }} <a href="https://phelipecurty.vercel.app" target="_blank" class="hover:text-amber-600 ">Phelipe Curty</a></div>
        <div class="flex gap-4">
            <a href="/" class="hover:text-amber-600 ">Início</a>
            <a href="{{ url('/admin') }}" class="hover:text-amber-600 ">Painel</a>
        </div>
    </div>
</footer>