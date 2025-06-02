<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Komendy Artisan do zarejestrowania
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\TestModuleObserver::class,
        \App\Console\Commands\TestObserverCommand::class
        // Tutaj wpisz swoje komendy, np. \App\Console\Commands\MyCommand::class,
    ];

    /**
     * Harmonogram zadań
     */
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
        // Możesz tu zaplanować zadania cron
    }

    /**
     * Rejestracja komend
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
