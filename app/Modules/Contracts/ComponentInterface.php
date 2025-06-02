<?php
namespace App\Modules\Contracts;

interface ComponentInterface
{
    public function getSlug(): string;
    public function getName(): string;
    public function register();
    public function enable();
    public function disable();
    public function isEnabled(): bool;

        // Dodaj metody do obsługi zdarzeń
    public function onEvent(string $eventName, $payload = null);
}
