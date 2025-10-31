<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VagasMage') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50 text-neutral-900 antialiased">
    <!-- Navbar -->
    <header class="border-b border-neutral-200/70 bg-white/80 backdrop-blur">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/" class="inline-flex items-center gap-2 font-semibold text-lg">
                    <span class="inline-block w-8 h-8 rounded-md bg-gradient-to-br from-amber-500 to-orange-600"></span>
                    <span>VagasMage</span>
                </a>
                <span class="hidden md:inline-block text-neutral-400">•</span>
                <span class="hidden md:inline-block text-neutral-600">Conectando talentos e empresas</span>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/admin') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-neutral-900 text-white hover:bg-black">Painel</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-neutral-800 hover:bg-neutral-100">Entrar</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-neutral-900 text-white hover:bg-black">Criar conta</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-amber-100/60 via-orange-100/40 to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <h1 class="text-3xl sm:text-5xl font-bold tracking-tight">
                        Encontre seu próximo desafio ou o talento ideal
                    </h1>
                    <p class="mt-4 text-neutral-700 text-lg">
                        Empresas publicam vagas com clareza. Profissionais se candidatam com currículos bem apresentados.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="#vagas" class="px-5 py-2.5 rounded-md bg-neutral-900 text-white hover:bg-black font-medium">Ver vagas</a>
                        <a href="#curriculos" class="px-5 py-2.5 rounded-md bg-white text-neutral-900 ring-1 ring-neutral-200 hover:bg-neutral-50 font-medium">Melhores currículos</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-xl p-1 bg-gradient-to-br from-amber-500 via-orange-500 to-red-500">
                        <div class="rounded-lg bg-white p-6 shadow-sm">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-lg bg-neutral-100 h-24"></div>
                                <div class="rounded-lg bg-neutral-100 h-24"></div>
                                <div class="rounded-lg bg-neutral-100 h-24"></div>
                                <div class="rounded-lg bg-neutral-100 h-24"></div>
                            </div>
                            <p class="mt-4 text-sm text-neutral-600">
                                Visual moderno, experiência simples, foco em resultado.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Principais vagas -->
    <section id="vagas" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold">Principais vagas</h2>
            <a href="{{ url('/admin') }}" class="text-sm font-medium text-neutral-700 hover:text-neutral-900">Abrir painel</a>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($jobs ?? []) as $job)
                <article class="group rounded-lg border border-neutral-200 bg-white hover:shadow-sm transition">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-2 text-xs text-neutral-600">
                                <span class="w-2 h-2 rounded-full {{ $job->is_remote ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                                {{ $job->is_remote ? 'Remoto' : ($job->location ?: 'Local não informado') }}
                            </span>
                            @if($job->published_at)
                                <span class="text-xs text-neutral-500">{{ \Illuminate\Support\Carbon::parse($job->published_at)->diffForHumans() }}</span>
                            @endif
                        </div>
                        <h3 class="mt-2 text-lg font-semibold tracking-tight group-hover:text-neutral-900">
                            {{ $job->title }}
                        </h3>
                        <p class="mt-1 text-sm text-neutral-600">
                            {{ $job->company_name }}
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium text-neutral-800 hover:underline underline-offset-4">
                                Detalhes da vaga
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M13 5l7 7-7 7M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="rounded-lg border border-neutral-200 bg-white p-6 text-neutral-600">
                        Nenhuma vaga publicada ainda.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Melhores currículos -->
    <section id="curriculos" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-semibold">Melhores currículos</h2>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($resumes ?? []) as $resume)
                <article class="rounded-lg border border-neutral-200 bg-white hover:shadow-sm transition">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">{{ $resume->name }}</h3>
                            @if($resume->linkedin_url)
                                <a href="{{ $resume->linkedin_url }}" target="_blank" class="text-sm text-neutral-700 hover:underline underline-offset-4">LinkedIn</a>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-neutral-600">
                            {{ trim(($resume->city ?? '') . ' ' . ($resume->state ?? '')) }}
                            @if($resume->country) • {{ $resume->country }} @endif
                        </p>
                        @if($resume->summary)
                            <p class="mt-3 text-sm text-neutral-700 line-clamp-3">{{ $resume->summary }}</p>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('employees.show', $resume->id) }}" class="inline-flex items-center gap-2 text-sm font-medium text-neutral-800 hover:underline underline-offset-4">
                                Ver perfil
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M13 5l7 7-7 7M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="rounded-lg border border-neutral-200 bg-white p-6 text-neutral-600">
                        Nenhum currículo destacado ainda.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-neutral-200 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm text-neutral-600">
            © {{ date('Y') }} VagasMage. Feito com Laravel + Tailwind.
        </div>
    </footer>
</body>
</html>