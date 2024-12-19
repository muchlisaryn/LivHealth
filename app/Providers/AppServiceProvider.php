<?php
namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Events\ServingFilament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::serving(function (ServingFilament $event) {
        //     $user = Auth::user();

        //     // Cek apakah user memiliki role 'finance'
        //     if ($user && $user->role('finance')) {
        //         // Arahkan pengguna ke dashboard finance
        //         return redirect()->route('finance.dashboard');
        //     }
        // });
    }
}
