<?php
namespace Modules\ProfilUzytkownika\Components;

class PytaniaOdpowiedziComponent extends BaseComponent
{
    protected bool $enabled = false;

    public function getSlug(): string
    {
        return 'pytania-odpowiedzi';
    }

    public function getName(): string
    {
        return 'Pytania i odpowiedzi';
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
        // Tu obsłuż zdarzenia skierowane do tego komponentu, np:
        // if ($eventName === 'some.event') { ... }
    }

    public function register()
    {
        // Rejestracja tras i widoków pytań i odpowiedzi
    }
}
