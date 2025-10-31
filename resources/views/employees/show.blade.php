<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil do Candidato — {{ $employee->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php use Illuminate\Support\Facades\Storage; @endphp
</head>
<body class="bg-neutral-50 text-neutral-900 antialiased">
    <header class="border-b border-neutral-200/70 bg-white/80 backdrop-blur">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-sm font-medium text-neutral-800 hover:underline underline-offset-4">← Voltar</a>
            <span class="text-neutral-600">Perfil do candidato</span>
            <span></span>
        </nav>
    </header>

    <main>
        <!-- Hero com gradiente -->
        <section class="relative">
            <div class="absolute inset-0 bg-gradient-to-b from-amber-100/60 via-orange-100/40 to-transparent pointer-events-none"></div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <!-- Card do perfil -->
                <div class="rounded-2xl border border-neutral-200 bg-white shadow-sm">
                    <div class="p-6 sm:p-8">
                        <!-- Cabeçalho do perfil -->
                        <div class="flex items-start gap-6">
                            <!-- Avatar com inicial -->
                            <div class="shrink-0">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center text-2xl font-bold">
                                    {{ strtoupper(substr($employee->name ?? 'U', 0, 1)) }}
                                </div>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-3 flex-wrap">
                                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ $employee->name }}</h1>

                                    <div class="flex items-center gap-2">
                                        @if($employee->curriculum_pdf_path)
                                            <a href="{{ Storage::url($employee->curriculum_pdf_path) }}" target="_blank"
                                               class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-neutral-900 text-white hover:bg-black font-medium">
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M12 3v12m0 0l-3-3m3 3l3-3M6 21h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                Ver currículo 
                                            </a>
                                        @endif
                                        @if($employee->resume_path)
                                            <a href="{{ Storage::url($employee->resume_path) }}" target="_blank"
                                               class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-white text-neutral-900 ring-1 ring-neutral-200 hover:bg-neutral-50 font-medium">
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M4 7a2 2 0 012-2h8l4 4v9a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" stroke="currentColor" stroke-width="2"/></svg>
                                                Visualizar arquivo
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Localização -->
                                <p class="mt-2 text-sm text-neutral-600">
                                    {{ trim(($employee->city ?? '') . ' ' . ($employee->state ?? '')) }}
                                    @if($employee->country) • {{ $employee->country }} @endif
                                </p>

                                <!-- Chips de contato -->
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    @if($employee->phone)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-neutral-100 text-sm text-neutral-800">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M2 5a3 3 0 013-3h2a3 3 0 013 3v2a3 3 0 01-3 3h0a12 12 0 0012 12h0a3 3 0 013-3h2a3 3 0 003 3v2a3 3 0 01-3 3h-2C8.82 24 0 15.18 0 5V3a3 3 0 013-3H5z" stroke="currentColor" stroke-width="1.5"/></svg>
                                            {{ $employee->phone }}
                                        </span>
                                    @endif
                                    @if($employee->linkedin_url)
                                        <a href="{{ $employee->linkedin_url }}" target="_blank"
                                           class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 text-sm text-blue-700 hover:bg-blue-100">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5A2.5 2.5 0 107.48 6a2.5 2.5 0 00-2.5-2.5zM4.5 8h3v12h-3zM9 8h2.78v1.64h.04a3.05 3.05 0 012.74-1.5c2.93 0 3.47 1.93 3.47 4.45V20h-3v-4.9c0-1.17-.02-2.67-1.63-2.67-1.64 0-1.89 1.28-1.89 2.59V20H9z"/></svg>
                                            LinkedIn
                                        </a>
                                    @endif
                                    @if($employee->portfolio_url)
                                        <a href="{{ $employee->portfolio_url }}" target="_blank"
                                           class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-sm text-emerald-700 hover:bg-emerald-100">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M12 5l7 7-7 7-7-7 7-7z" stroke="currentColor" stroke-width="1.5"/></svg>
                                            Portfólio
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Sobre -->
                        @if($employee->summary)
                            <div class="mt-6">
                                <h2 class="text-lg font-semibold">Sobre</h2>
                                <p class="mt-2 text-neutral-700 leading-7">{{ $employee->summary }}</p>
                            </div>
                        @endif

                        <!-- Grid de detalhes -->
                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @if($employee->address)
                                <div class="rounded-lg border border-neutral-200 p-4">
                                    <span class="text-sm text-neutral-500">Endereço</span>
                                    <div class="mt-1 text-neutral-900 font-medium">{{ $employee->address }} {{ $employee->number }}</div>
                                </div>
                            @endif
                            @if($employee->phone)
                                <div class="rounded-lg border border-neutral-200 p-4">
                                    <span class="text-sm text-neutral-500">Telefone</span>
                                    <div class="mt-1 text-neutral-900 font-medium">{{ $employee->phone }}</div>
                                </div>
                            @endif
                            @if($employee->linkedin_url)
                                <div class="rounded-lg border border-neutral-200 p-4">
                                    <span class="text-sm text-neutral-500">LinkedIn</span>
                                    <a href="{{ $employee->linkedin_url }}" target="_blank" class="mt-1 inline-block text-neutral-900 font-medium hover:underline underline-offset-4">
                                        {{ $employee->linkedin_url }}
                                    </a>
                                </div>
                            @endif
                            @if($employee->portfolio_url)
                                <div class="rounded-lg border border-neutral-200 p-4">
                                    <span class="text-sm text-neutral-500">Portfólio</span>
                                    <a href="{{ $employee->portfolio_url }}" target="_blank" class="mt-1 inline-block text-neutral-900 font-medium hover:underline underline-offset-4">
                                        {{ $employee->portfolio_url }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>