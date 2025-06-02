<?php
namespace Modules\ProfilUzytkownika\Components;

class AnkietyEwaluacjeComponent extends BaseComponent
{
    protected bool $enabled = false;

    public function getSlug(): string
    {
        return 'ankiety-ewaluacje';
    }

    public function getName(): string
    {
        return 'Ankiety i Ewaluacje';
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
        // Obsługa zdarzeń, np.:
        // if ($eventName === 'survey.completed') { ... }
    }

    public function register()
    {
        // Rejestracja tras i widoków ankiet i ewaluacji
    }
}
