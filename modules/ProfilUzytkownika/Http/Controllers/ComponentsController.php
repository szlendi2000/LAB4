<?php

namespace Modules\ProfilUzytkownika\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\ProfilUzytkownika\ProfilUzytkownikaModule;

class ComponentsController extends Controller
{
    protected $module;

    public function __construct()
    {
        $this->module = new ProfilUzytkownikaModule(true);
    }

    public function index()
    {
        $components = $this->module->getComponents();

        return view('profil-uzytkownika::components.index', compact('components'));
    }

    public function toggle(Request $request)
    {
        $slug = $request->input('slug');
        $enable = $request->input('enable') === '1';

        if ($enable) {
            $this->module->enableComponent($slug);
        } else {
            $this->module->disableComponent($slug);
        }

        return redirect()->back()->with('success', 'Stan komponentu zaktualizowany.');
    }
}
