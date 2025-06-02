<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ModuleService
{
    protected string $path = 'Modules/';

    public function scanModules()
    {
        $modules = [];

        foreach (File::directories(base_path($this->path)) as $dir) {
            $jsonPath = $dir . '/module.json';
            if (File::exists($jsonPath)) {
                $data = json_decode(File::get($jsonPath), true);
                $modules[] = $data;
                // rejestracja w bazie jeśli nie istnieje
                DB::table('modules')->updateOrInsert(
                    ['slug' => $data['slug']],
                    [
                        'name' => $data['name'],
                        'version' => $data['version'],
                        'description' => $data['description'],
                        'enabled' => $data['enabled']
                    ]
                );
            }
        }

        return $modules;
    }
    public function installFromZip($uploadedZip)
{
    $zip = new \ZipArchive;
    $zip->open($uploadedZip);
    $tempDir = storage_path('app/module_temp');

    $zip->extractTo($tempDir);
    $zip->close();

    $moduleJson = json_decode(file_get_contents($tempDir . '/module.json'), true);
    $moduleSlug = $moduleJson['slug'];
    $targetPath = base_path("Modules/{$moduleSlug}");

    File::copyDirectory($tempDir, $targetPath);
    File::deleteDirectory($tempDir);

    $this->scanModules();
}

}