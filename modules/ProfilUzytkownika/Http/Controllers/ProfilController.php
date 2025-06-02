<?php

namespace Modules\ProfilUzytkownika\Http\Controllers;

use App\Http\Controllers\Controller; // lub bezpośrednio z Laravel jeśli masz swój bazowy controller

class ProfilController extends Controller
{
    public function index()
    {
        // zwróć widok modułu Profil
        return view('profil-uzytkownika::profil.index');
    }
}
