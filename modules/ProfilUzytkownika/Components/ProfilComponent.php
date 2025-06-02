<?php
namespace Modules\ProfilUzytkownika\Components;

class ProfilComponent extends BaseComponent
{
    protected bool $enabled = false;  // stan komponentu

    public function getSlug(): string
    {
        return 'profil-uzytkownika.profil';
    }

    public function getName(): string
    {
        return 'Profil';
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

    public function render(): string
    {
        return view('profil-uzytkownika::components.profil')->render();
    }

    public function onEvent(string $eventName, $payload = null)
    {
        // Tu możesz dodać reakcję na eventy, jeśli potrzebujesz
    }

    public function register()
    {
        // Tu rejestrujesz trasy / widoki jeśli trzeba
    }
}
