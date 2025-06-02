<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\ModuleManager;

class TestObserverCommand extends Command
{
    // Nazwa komendy Artisan
    protected $signature = 'test:observer';

    // Opis komendy
    protected $description = 'Testowanie mechanizmu Observer i rejestracji komponentów';

    protected $moduleManager;

    public function __construct(ModuleManager $moduleManager)
    {
        parent::__construct();
        $this->moduleManager = $moduleManager;
    }

    public function handle()
    {
        // Załaduj moduły i komponenty
        $this->moduleManager->loadModules();

        // Wywołaj zdarzenie testowe
        $this->moduleManager->notifyComponents('test.event', ['message' => 'Hello Observer z Artisan!']);

        $this->info('Wysłano zdarzenie testowe do komponentów.');
    }
}
