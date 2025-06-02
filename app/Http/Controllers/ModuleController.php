<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\File;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = DB::table('modules')->get();
        return view('admin.modules', compact('modules'));
    }

    public function enable($slug)
    {
        DB::table('modules')->where('slug', $slug)->update(['enabled' => true]);
        return back()->with('success', "Moduł $slug został włączony.");
    }

    public function disable($slug)
    {
        DB::table('modules')->where('slug', $slug)->update(['enabled' => false]);
        return back()->with('success', "Moduł $slug został wyłączony.");
    }
      public function showInstallForm()
    {
        return view('admin.modules.install');
    }
    public function install(Request $request)
    {
        $request->validate([
            'module_zip' => 'required|file|mimes:zip',
        ]);

        $zip = $request->file('module_zip');
        $zipPath = $zip->getRealPath();

        $zipArchive = new ZipArchive;
        if ($zipArchive->open($zipPath) === true) {
            // Ścieżka docelowa wypakowania modułu
            $extractPath = base_path('modules/' . uniqid('module_'));
            File::makeDirectory($extractPath, 0755, true);

            $zipArchive->extractTo($extractPath);
            $zipArchive->close();

            // Załóżmy, że metadane są w pliku module.json w katalogu modułu
            $metadataPath = $extractPath . '/module.json';
            if (!File::exists($metadataPath)) {
                // usuń folder, jeśli metadane brak
                File::deleteDirectory($extractPath);
                return back()->withErrors(['module_zip' => 'Brak pliku module.json z metadanymi modułu.']);
            }

            $metadata = json_decode(File::get($metadataPath), true);

            if (!$metadata || !isset($metadata['slug'], $metadata['name'])) {
                File::deleteDirectory($extractPath);
                return back()->withErrors(['module_zip' => 'Niepoprawne metadane w module.json.']);
            }

            // Zapis do bazy danych
            DB::table('modules')->updateOrInsert(
                ['slug' => $metadata['slug']],
                [
                    'name' => $metadata['name'],
                    'version' => $metadata['version'] ?? null,
                    'description' => $metadata['description'] ?? null,
                    'enabled' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            return redirect()->route('modules.index')->with('success', 'Moduł został poprawnie zainstalowany. Możesz go teraz włączyć w panelu.');
        } else {
            return back()->withErrors(['module_zip' => 'Nie udało się otworzyć archiwum ZIP.']);
        }
    }
}
