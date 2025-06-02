<?php

namespace Modules\ProfilUzytkownika\Repositories;

use Illuminate\Support\Facades\DB;

class ComponentStateRepository
{
    public static function getStateForModule(string $moduleSlug): array
    {
        $rows = DB::table('component_states')
            ->where('module_slug', $moduleSlug)
            ->get();

        $state = [];
        foreach ($rows as $row) {
            $state[$row->component_slug] = (bool)$row->enabled;
        }

        return $state;
    }

    public static function setState(string $moduleSlug, string $componentSlug, bool $enabled): void
    {
        DB::table('component_states')->updateOrInsert(
            ['module_slug' => $moduleSlug, 'component_slug' => $componentSlug],
            ['enabled' => $enabled, 'updated_at' => now()]
        );
    }
}
