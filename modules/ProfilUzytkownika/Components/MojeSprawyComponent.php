<?php

namespace Modules\ProfilUzytkownika\Components;

class MojeSprawyComponent extends BaseComponent
{
    protected bool $enabled = false;

    public function getSlug(): string
    {
        return 'profil-uzytkownika.moje-sprawy';
    }

    public function getName(): string
    {
        return 'Moje sprawy';
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function onEvent(string $eventName, $payload = null)
    {
        // Tutaj możesz dodać obsługę zdarzeń, jeśli potrzeba
    }

    public function register()
    {
        // Rejestracja tras i widoków moich spraw, jeśli potrzebna
    }
}
