<?php
namespace Modules\ProfilUzytkownika\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\ProfilUzytkownika\ProfilUzytkownikaModule;
use Illuminate\Http\Request;

class ProfilUzytkownikaController extends Controller
{
    protected ProfilUzytkownikaModule $module;

    public function __construct()
    {
        $this->module = new ProfilUzytkownikaModule(true);
    }

    public function index(Request $request)
    {
        $components = $this->module->getComponents();

        $selectedSlug = $request->query('component');
        $selectedComponent = null;

        foreach ($components as $component) {
            if ($component->getSlug() === $selectedSlug) {
                $selectedComponent = $component;
                break;
            }
        }

        if (!$selectedComponent) {
            foreach ($components as $component) {
                if ($component->isEnabled()) {
                    $selectedComponent = $component;
                    break;
                }
            }
        }

        return view('profil.panel', compact('components', 'selectedComponent'));
    }

    public function toggleComponent(Request $request)
    {
        $slug = $request->input('slug');
        $enable = $request->input('enable') === '1';

        if ($enable) {
            $this->module->enableComponent($slug);
        } else {
            $this->module->disableComponent($slug);
        }

        return redirect()->route('profil.components.panel')->with('status', 'Zmieniono status komponentu.');
    }
}
