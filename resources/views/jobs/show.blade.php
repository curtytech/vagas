<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->title }} • {{ $job->company_name }} • VagasMage</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50 text-neutral-900 antialiased">
    <!-- Navbar -->
    <header class="border-b border-neutral-200/70 bg-white/80 backdrop-blur">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="inline-flex items-center gap-2 font-semibold text-lg">
                <span class="inline-block w-8 h-8 rounded-md bg-gradient-to-br from-amber-500 to-orange-600"></span>
                <span>VagasMage</span>
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/admin') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-neutral-900 text-white hover:bg-black">Painel</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-neutral-800 hover:bg-neutral-100">Entrar</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <!-- Conteúdo -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Card principal -->
            <section class="lg:col-span-2">
                <div class="rounded-lg border border-neutral-200 bg-white p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ $job->title }}</h1>
                            <p class="mt-1 text-neutral-700 font-medium">{{ $job->company_name }}</p>
                            <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-neutral-600">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $job->is_remote ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                                    {{ $job->is_remote ? 'Remoto' : ($job->location ?: 'Local não informado') }}
                                </span>
                                <span>•</span>
                                <span class="capitalize">
                                    @switch($job->employment_type)
                                        @case('full_time') Full-time @break
                                        @case('part_time') Part-time @break
                                        @case('contract') Contrato @break
                                        @case('internship') Estágio @break
                                        @default -
                                    @endswitch
                                </span>
                                @if($job->published_at)
                                    <span>•</span>
                                    <span>Publicada {{ \Illuminate\Support\Carbon::parse($job->published_at)->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            @if(!is_null($job->salary_min) || !is_null($job->salary_max))
                                <div class="text-sm text-neutral-600">Faixa salarial</div>
                                <div class="text-lg font-semibold">
                                    @php
                                        $min = $job->salary_min ? number_format($job->salary_min, 2, ',', '.') : null;
                                        $max = $job->salary_max ? number_format($job->salary_max, 2, ',', '.') : null;
                                    @endphp
                                    R$
                                    @if($min && $max)
                                        {{ $min }} até {{ $max }}
                                    @elseif($min)
                                        {{ $min }}+
                                    @elseif($max)
                                        até {{ $max }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="my-6 border-neutral-200">

                    <article class="prose max-w-none prose-neutral">
                        {!! nl2br(e($job->description)) !!}
                    </article>

                    <div class="mt-8">
                        <a href="#" class="px-4 py-2 rounded-md bg-neutral-900 text-white hover:bg-black font-medium inline-flex items-center gap-2">
                            Candidatar-se
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M13 5l7 7-7 7M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="rounded-lg border border-neutral-200 bg-white p-6">
                    <h3 class="text-lg font-semibold">Sobre a empresa</h3>
                    <dl class="mt-4 space-y-2 text-sm text-neutral-700">
                        <div class="flex items-center justify-between">
                            <dt>Nome</dt>
                            <dd class="font-medium">{{ $job->company_name }}</dd>
                        </div>
                        @if($job->website_url)
                        <div class="flex items-center justify-between">
                            <dt>Site</dt>
                            <dd>
                                <a href="{{ $job->website_url }}" target="_blank" class="text-neutral-800 hover:underline underline-offset-4">
                                    {{ parse_url($job->website_url, PHP_URL_HOST) ?? $job->website_url }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        <div class="flex items-center justify-between">
                            <dt>Status</dt>
                            <dd class="capitalize">{{ $job->status }}</dd>
                        </div>
                    </dl>
                </div>
            </aside>
        </div>
    </main>

    <footer class="border-t border-neutral-200 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm text-neutral-600">
            © {{ date('Y') }} VagasMage.
        </div>
    </footer>
</body>
</html>