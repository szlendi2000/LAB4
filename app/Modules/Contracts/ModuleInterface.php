<?php
namespace App\Modules\Contracts;

interface ModuleInterface
{
    // Unikalny slug modułu
    public function getSlug(): string;

    // Nazwa modułu
    public function getName(): string;

    // Rejestracja usług i konfiguracji (np. trasy, widoki)
    public function register();

    // Metoda wywoływana przy włączeniu modułu
    public function enable();

    // Metoda wywoływana przy wyłączeniu modułu
    public function disable();

    // Czy moduł jest aktywny
    public function isEnabled(): bool;

    /**
     * Zwraca listę komponentów (podmodułów) w tym module.
     * Każdy komponent implementuje ComponentInterface.
     *
     * @return ComponentInterface[]
     */
    public function getComponents(): array;
        // Dodaj metody do obsługi zdarzeń
    public function onEvent(string $eventName, $payload = null);
}
