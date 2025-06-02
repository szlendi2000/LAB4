<?php
namespace Modules\ProfilUzytkownika\Components;

use App\Modules\Contracts\ComponentInterface;

abstract class BaseComponent implements ComponentInterface
{
    protected bool $enabled = false;

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

    public function register()
    {
        // Możesz tutaj rejestrować trasy, widoki itp.
    }
}
