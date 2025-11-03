@extends('layouts.app')

@section('title', $job->title . ' • ' . $job->company_name . ' • VagasMage')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl md:text-3xl font-bold">{{ $job->title }}</h1>
        <div class="mt-2 text-neutral-600 dark:text-neutral-400">{{ $job->company_name }}</div>
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
    </main>
@endsection