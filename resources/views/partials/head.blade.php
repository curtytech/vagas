<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <title>@yield('title', $title ?? 'VagasMage')</title>

    <script>
        (function() {
            const key = 'theme';
            let stored;
            try {
                stored = localStorage.getItem(key);
            } catch (e) {}
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initial = stored ? stored : (prefersDark ? 'dark' : 'light');
            if (initial === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>