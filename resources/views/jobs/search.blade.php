    @extends('layouts.app')

    @section('title', 'Buscar vagas • VagasMage')

    @section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-semibold">Buscar vagas</h1>
        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">Filtre por título, empresa, local e remoto.</p>

        <form action="{{ route('jobs.search') }}" method="GET" class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Termo</label>
                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Ex.: Desenvolvedor, Empresa..."
                    class="mt-1 w-full rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 px-3 py-2 focus:ring-2 focus:ring-amber-500">
            </div>
            <div>
                <label class="block text-sm font-medium">Local</label>
                <input type="text" name="location" value="{{ $filters['location'] ?? '' }}" placeholder="Ex.: São Paulo"
                    class="mt-1 w-full rounded-md border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 px-3 py-2 focus:ring-2 focus:ring-amber-500">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="remote" name="remote" value="1" {{ ($filters['remote'] ?? '') === '1' ? 'checked' : '' }}
                    class="rounded border-neutral-300 dark:border-neutral-700">
                <label for="remote" class="text-sm">Somente remoto</label>
            </div>
            <div class="md:col-span-4">
                <button type="submit" class="inline-flex items-center rounded-md bg-amber-600 text-white px-4 py-2 text-sm hover:bg-amber-700">
                    Buscar
                </button>
            </div>
        </form>

        <div class="mt-8">
            @if($jobs->count() === 0)
            <div class="rounded-lg border border-neutral-200 dark:border-neutral-800 p-6 bg-white/70 dark:bg-neutral-900/60">
                Nenhuma vaga encontrada para os filtros informados.
            </div>
            @else
            <div class="flex items-center justify-between">
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    Resultados: {{ $jobs->total() }}
                </div>
                <div>
                    {{ $jobs->links() }}
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                <article class="group rounded-lg border border-neutral-200 bg-white hover:shadow-sm transition dark:border-neutral-800 dark:bg-neutral-900">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-2 text-xs text-neutral-600 dark:text-neutral-400">
                                <span class="w-2 h-2 rounded-full {{ $job->is_remote ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                                {{ $job->is_remote ? 'Remoto' : ($job->location ?: 'Local não informado') }}
                            </span>
                            @if($job->published_at)
                            <span class="text-xs text-neutral-500 dark:text-neutral-500">{{ \Illuminate\Support\Carbon::parse($job->published_at)->diffForHumans() }}</span>
                            @endif
                        </div>
                        <h3 class="mt-3 text-lg font-semibold">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="hover:underline">
                                {{ $job->title }}
                            </a>
                        </h3>
                        <div class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $job->company_name }}
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
            @endif
        </div>
    </main>
    @endsection