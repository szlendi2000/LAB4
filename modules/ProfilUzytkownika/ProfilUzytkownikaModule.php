<?php
namespace Modules\ProfilUzytkownika;

use App\Modules\Contracts\ModuleInterface;
use Modules\ProfilUzytkownika\Components\ProfilComponent;
use Modules\ProfilUzytkownika\Components\DanePersonalneComponent;
use Modules\ProfilUzytkownika\Components\MojeSprawyComponent;
use Modules\ProfilUzytkownika\Components\AnkietyEwaluacjeComponent;
use Modules\ProfilUzytkownika\Components\PytaniaOdpowiedziComponent;
use Modules\ProfilUzytkownika\Repositories\ComponentStateRepository;

class ProfilUzytkownikaModule implements ModuleInterface
{
    protected array $components = [];
    protected bool $enabled;
    
    // Przechowuje stan komponentów
    protected array $componentsState = [];

    public function __construct(bool $enabled = false)
    {
        $this->enabled = $enabled;
        $this->componentsState = ComponentStateRepository::getStateForModule($this->getSlug());
        logger()->info('componentsState:', $this->componentsState);
        $this->initComponents($this->componentsState);
        foreach ($this->components as $component) {
        logger()->info("Component '{$component->getSlug()}' enabled? " . ($component->isEnabled() ? 'true' : 'false'));
}
    }

    protected function initComponents(array $componentsState = [])
    {
        $this->components = [
            new ProfilComponent(),
            new DanePersonalneComponent(),
            new MojeSprawyComponent(),
            new AnkietyEwaluacjeComponent(),
            new PytaniaOdpowiedziComponent(),
        ];

        foreach ($this->components as $component) {
            $slug = $component->getSlug();
            if (isset($componentsState[$slug]) && $componentsState[$slug] === false) {
                $component->disable();
            } else {
                $component->enable();
            }
        }
    }

    public function onEvent(string $eventName, $payload = null)
    {
        foreach ($this->components as $component) {
            if (method_exists($component, 'onEvent')) {
                $component->onEvent($eventName, $payload);
            }
        }
    }

    public function getSlug(): string
    {
        return 'profil-uzytkownika';
    }

    public function getName(): string
    {
        return 'Profil użytkownika';
    }

    public function register()
    {
        if (file_exists(__DIR__.'/routes/web.php')) {
            \Illuminate\Support\Facades\Route::middleware('web')
                ->namespace('Modules\ProfilUzytkownika\Http\Controllers')
                ->group(__DIR__.'/routes/web.php');
        }

        foreach ($this->components as $component) {
            if ($component->isEnabled()) {
                $component->register();
            }
        }
    }

    public function enable()
    {
        $this->enabled = true;
        foreach ($this->components as $component) {
            $component->enable();
            ComponentStateRepository::setState($this->getSlug(), $component->getSlug(), true);
        }
        // Możesz zapisać stan modułu jeśli potrzebujesz
    }

    public function disable()
    {
        $this->enabled = false;
        foreach ($this->components as $component) {
            $component->disable();
            ComponentStateRepository::setState($this->getSlug(), $component->getSlug(), false);
        }
        // Możesz zapisać stan modułu jeśli potrzebujesz
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function enableComponent(string $slug): bool
    {
        foreach ($this->components as $component) {
            if ($component->getSlug() === $slug) {
                $component->enable();
                ComponentStateRepository::setState($this->getSlug(), $slug, true);
                return true;
            }
        }
        return false;
    }

    public function disableComponent(string $slug): bool
    {
        foreach ($this->components as $component) {
            if ($component->getSlug() === $slug) {
                $component->disable();
                ComponentStateRepository::setState($this->getSlug(), $slug, false);
                return true;
            }
        }
        return false;
    }

    
}
