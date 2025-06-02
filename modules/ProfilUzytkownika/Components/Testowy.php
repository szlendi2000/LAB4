<?php
namespace Modules\ProfilUzytkownika\Components;

use App\Modules\Contracts\ComponentInterface;

class TestObserverComponent implements ComponentInterface
{
    protected bool $enabled = false;

    public function getSlug(): string
    {
        return 'test-observer';
    }

    public function getName(): string
    {
        return 'Test Observer Component';
    }

    public function register()
    {
        echo "Component '{$this->getName()}' registered.\n";
    }

    public function enable()
    {
        $this->enabled = true;
        echo "Component '{$this->getName()}' enabled.\n";
    }

    public function disable()
    {
        $this->enabled = false;
        echo "Component '{$this->getName()}' disabled.\n";
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    // **Metoda obsługująca zdarzenia (Observer pattern)**
    public function onEvent(string $eventName, $payload = null)
    {
        echo "Component '{$this->getName()}' received event '{$eventName}'";
        if ($payload !== null) {
            echo " with payload: " . json_encode($payload);
        }
        echo "\n";
    }
}
