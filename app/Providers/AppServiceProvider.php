<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define dark como padrão no painel Filament se não houver preferência
        FilamentView::registerRenderHook(
            'panels::scripts.after',
            fn (): string => <<<'HTML'
                <script>
                    try {
                        if (localStorage.getItem('theme') === null) {
                            localStorage.setItem('theme', 'dark');
                        }
                    } catch (e) {}
                </script>
            HTML,
        );
    }
}
