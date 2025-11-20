@extends('layouts.app')

@section('title', 'Criar conta • VagasMage')

@section('content')
<main class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold text-neutral-800">Criar conta</h1>

    @if(session('success'))
        <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-neutral-700">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}"
                   class="mt-1 w-full rounded-md border border-neutral-200 px-3 py-2"
                   required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-neutral-700">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   class="mt-1 w-full rounded-md border border-neutral-200 px-3 py-2"
                   required>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-neutral-700">Senha</label>
            <input id="password" name="password" type="password"
                   class="mt-1 w-full rounded-md border border-neutral-200 px-3 py-2"
                   required>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-neutral-700">Confirmar senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="mt-1 w-full rounded-md border border-neutral-200 px-3 py-2"
                   required>
        </div>

        <div>
            <span class="block text-sm font-medium text-neutral-700">Perfil</span>
            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="flex items-center gap-2 rounded-md border border-neutral-200 px-3 py-2 cursor-pointer">
                    <input type="radio" name="role" value="employee" {{ old('role', 'employee') === 'employee' ? 'checked' : '' }}>
                    <span>Candidato</span>
                </label>
                <label class="flex items-center gap-2 rounded-md border border-neutral-200 px-3 py-2 cursor-pointer">
                    <input type="radio" name="role" value="enterprise" {{ old('role') === 'enterprise' ? 'checked' : '' }}>
                    <span>Empresa</span>
                </label>
            </div>
            @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-neutral-900 text-white hover:bg-black">
                Cadastrar
            </button>
        </div>
    </form>

    <p class="mt-4 text-sm text-neutral-600">
        Já tem conta?
        <a href="{{ url('/admin/login') }}" class="font-medium text-neutral-800 hover:underline underline-offset-4">Entrar</a>
    </p>
</main>
@endsection