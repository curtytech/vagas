@extends('layouts.app')

@section('title', $job->title . ' • ' . $job->company_name . ' • VagasMage')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="mb-4 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
                {{ session('info') }}
            </div>
        @endif
        <h1 class="text-2xl md:text-3xl font-bold text-neutral-700">{{ $job->title }}</h1>
        <div class="mt-2 text-neutral-600">{{ $job->company_name }}</div>        
        <div class="text-right">
            @if(!is_null($job->salary_min) || !is_null($job->salary_max))
            <div class="text-sm text-neutral-600">Faixa salarial</div>
            <div class="text-lg font-semibold text-neutral-700">
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

        <!-- Descrição da vaga -->
        <section class="mt-8">
            <h2 class="text-lg font-semibold text-neutral-800">Descrição</h2>
            <div class="mt-3 prose prose-neutral max-w-none text-neutral-700">
                {!! nl2br(e($job->description)) !!}
            </div>
        </section>

        <!-- Campos relacionados à vaga -->
        <section class="mt-8">
            <h2 class="text-lg font-semibold text-neutral-800">Detalhes</h2>
            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="text-xs text-neutral-500">Status</div>
                    <div class="mt-1 text-sm font-medium text-neutral-800 capitalize">
                        @switch($job->status)
                            @case('draft') Rascunho @break
                            @case('published') Publicada @break
                            @case('closed') Encerrada @break
                            @default -
                        @endswitch
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="text-xs text-neutral-500">Expira em</div>
                    <div class="mt-1 text-sm font-medium text-neutral-800">
                        @if($job->expires_at)
                            {{ \Illuminate\Support\Carbon::parse($job->expires_at)->translatedFormat('d/m/Y H:i') }}
                        @else
                            —
                        @endif
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="text-xs text-neutral-500">Local</div>
                    <div class="mt-1 text-sm font-medium text-neutral-800">
                        {{ $job->location ?: 'Local não informado' }}
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="text-xs text-neutral-500">Remoto</div>
                    <div class="mt-1 text-sm font-medium text-neutral-800">
                        {{ $job->is_remote ? 'Sim' : 'Não' }}
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="text-xs text-neutral-500">Tipo de contratação</div>
                    <div class="mt-1 text-sm font-medium text-neutral-800 capitalize">
                        @switch($job->employment_type)
                            @case('full_time') Full-time @break
                            @case('part_time') Part-time @break
                            @case('contract') Contrato @break
                            @case('internship') Estágio @break
                            @default -
                        @endswitch
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="text-xs text-neutral-500">Acessos</div>
                    <div class="mt-1 text-sm font-medium text-neutral-800">
                        {{ number_format((int) $job->access_count, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </section>

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
                <span class="text-neutral-600">Publicada {{ \Illuminate\Support\Carbon::parse($job->published_at)->diffForHumans() }}</span>
            @endif
        </div>
        
        <!-- Candidatar-se -->
        <form method="POST" action="{{ route('jobs.apply', $job->slug) }}" class="mt-8">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-neutral-900 text-white hover:bg-black">
                Candidatar-se
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                    <path d="M13 5l7 7-7 7M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
        </form>
    </main>
@endsection