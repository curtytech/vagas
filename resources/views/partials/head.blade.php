<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', $title ?? 'VagasMage')</title>

    <script>
        (function () {
            const key = 'theme';
            let stored;
            try { stored = localStorage.getItem(key); } catch (e) {}
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initial = stored ? stored : (prefersDark ? 'dark' : 'light');
            if (initial === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>