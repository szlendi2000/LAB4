<?php

namespace App\Modules;

use Illuminate\Support\Facades\DB;
use App\Modules\Contracts\ModuleInterface;
use App\Modules\Contracts\ComponentInterface;
use Illuminate\Support\Str;

class ModuleManager
{
    protected array $modules = [];
    protected ComponentRegistry $componentRegistry;

    public function __construct()
    {
        $this->componentRegistry = new ComponentRegistry();
    }

    public function loadModules()
    {
        $modulesFromDb = DB::table('modules')->where('enabled', true)->get();

        foreach ($modulesFromDb as $moduleData) {
            $class = '\\Modules\\' . Str::studly($moduleData->slug) . '\\' . Str::studly($moduleData->slug) . 'Module';

            if (class_exists($class)) {
                /** @var ModuleInterface $module */
                $module = new $class(true);
                $module->register();
                $this->modules[$module->getSlug()] = $module;

                // Rejestruj komponenty modułu w ComponentRegistry
                foreach ($module->getComponents() as $component) {
                    $this->componentRegistry->registerComponent($component);
                }
            }
        }
    }

    /**
     * Zwraca załadowane moduły
     * @return ModuleInterface[]
     */
    public function getModules(): array
    {
        return $this->modules;
    }

    /**
     * Zwraca wszystkie aktywne komponenty (podmoduły) z włączonych modułów
     * 
     * @return ComponentInterface[] Tablica komponentów
     */
    public function getEnabledComponents(): array
    {
        return $this->componentRegistry->getEnabledComponents();
    }

    /**
     * Zwraca wszystkie komponenty (zarówno włączone, jak i wyłączone) z załadowanych modułów
     * 
     * @return ComponentInterface[]
     */
    public function getAllComponents(): array
    {
        $components = [];

        foreach ($this->modules as $module) {
            foreach ($module->getComponents() as $component) {
                $components[$component->getSlug()] = $component;
            }
        }

        return $components;
    }

    /**
     * Włącza komponent (np. z panelu zarządzania)
     */
    public function enableComponent(string $slug)
    {
        $this->componentRegistry->enableComponent($slug);
    }

    /**
     * Wyłącza komponent (np. z panelu zarządzania)
     */
    public function disableComponent(string $slug)
    {
        $this->componentRegistry->disableComponent($slug);
    }

    /**
     * Przekazuje zdarzenie do komponentów
     */
    public function notifyComponents(string $eventName, $payload = null)
    {
        $this->componentRegistry->notify($eventName, $payload);
    }
    
}

class ComponentRegistry
{
    /** @var ComponentInterface[] */
    protected array $components = [];

    public function registerComponent(ComponentInterface $component)
    {
        $slug = $component->getSlug();
        if (!isset($this->components[$slug])) {
            $this->components[$slug] = $component;
            $component->register();
        }
    }

    public function enableComponent(string $slug)
    {
        if (isset($this->components[$slug]) && !$this->components[$slug]->isEnabled()) {
            $this->components[$slug]->enable();
            $this->notify('component.enabled', $this->components[$slug]);
        }
    }

    public function disableComponent(string $slug)
    {
        if (isset($this->components[$slug]) && $this->components[$slug]->isEnabled()) {
            $this->components[$slug]->disable();
            $this->notify('component.disabled', $this->components[$slug]);
        }
    }

    /**
     * Zwraca wszystkie aktywne komponenty
     * @return ComponentInterface[]
     */
    public function getEnabledComponents(): array
    {
        return array_filter($this->components, fn($component) => $component->isEnabled());
    }

    /**
     * Powiadamia wszystkie komponenty o zdarzeniu
     */
    public function notify(string $eventName, $payload = null)
    {
        foreach ($this->components as $component) {
            if (method_exists($component, 'onEvent')) {
                $component->onEvent($eventName, $payload);
            }
        }
    }
}