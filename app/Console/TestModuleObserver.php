<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\ModuleManager;

class TestModuleObserver extends Command
{
    protected $signature = 'test:observer';
    protected $description = 'Testuje mechanizm observer dla komponentów';

    public function handle()
    {
        $moduleManager = app(ModuleManager::class);
        $moduleManager->loadModules();

        $this->info('Moduły i komponenty załadowane.');
        $moduleManager->notifyComponents('test.event', ['message' => 'Test event z Artisan Command']);
        $this->info('Event wysłany do komponentów.');
    }
}
