<header class="border-b border-neutral-200/70 bg-white/80 backdrop-blur ">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="/" class="inline-flex items-center gap-2 font-semibold text-lg">
                <span class="inline-block w-8 h-8 rounded-md bg-gradient-to-br from-amber-500 to-orange-600 text-center"><i class="fas fa-briefcase text-white"></i></span>
                <span class="text-neutral-800">VagasMage</span>
            </a>
            <span class="hidden md:inline-block text-neutral-800">•</span>
            <span class="hidden md:inline-block text-neutral-800">Conectando talentos e empresas</span>            
        </div>

        <div class="flex items-center gap-3">
            <!-- <button id="themeToggle" class="inline-flex items-center gap-2 rounded-md border border-neutral-200 dark:border-neutral-800 px-3 py-2 text-xs hover:bg-neutral-100 dark:hover:bg-neutral-900">
                <span id="themeToggleIconLight" class="">☀️ Claro</span>
                <span id="themeToggleIconDark" class="hidden ">🌙 Escuro</span>
            </button> -->
                        
            @auth
            <span class="hidden md:inline-block text-neutral-800">Olá, {{ auth()->user()->name }}</span>
            <a href="{{ url('/admin') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-orange-600 text-white hover:bg-black">Painel</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium bg-black text-white hover:bg-orange-600" title="Sair">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
            @endauth

            @if(!auth()->check())
            <a href="{{ url('/admin') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-neutral-900 text-white hover:bg-black">Login</a>
            @endif
            
        </div>
    </nav>
</header>