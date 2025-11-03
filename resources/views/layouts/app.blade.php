<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.head')

<body class="min-h-screen bg-white dark:bg-neutral-950 text-neutral-800 dark:text-neutral-200 antialiased">
    @include('partials.header')

    <main class="min-h-[60vh]">
        @yield('content')
    </main>

    @include('partials.footer')
</body>

</html>