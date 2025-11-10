<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.head')

<body class="min-h-screen bg-white text-black antialiased">
    @include('partials.header')

    <main class="min-h-[60vh]">
        @yield('content')
    </main>

    @include('partials.footer')
</body>

</html>