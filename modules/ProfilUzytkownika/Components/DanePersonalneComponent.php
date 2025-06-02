<?php
namespace Modules\ProfilUzytkownika\Components;

class DanePersonalneComponent extends BaseComponent
{
    protected bool $enabled = false;

    public function getSlug(): string
    {
        return 'dane-personalne';
    }

    public function getName(): string
    {
        return 'Dane personalne';
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function onEvent(string $eventName, $payload = null)
    {
        // Obsługa zdarzeń, np:
        // if ($eventName === 'user.updated') { ... }
    }

    public function register()
    {
        // Rejestracja tras i widoków danych personalnych
    }
}
