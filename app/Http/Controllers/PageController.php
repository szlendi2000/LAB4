<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function kontakt()
    {
        return view('kontakt');
    }

    public function oferta()
    {
        return view('oferta');
    }

    public function logowanie()
    {
        return view('logowanie');
    }

    public function profil()
    {
        $profilModule = app(\Modules\ProfilUzytkownika\ProfilUzytkownikaModule::class);

    $components = array_filter($profilModule->getComponents(), function($component) {
        return $component->isEnabled();
    });

    return view('profil', compact('components'));
    }

    public function kontaktFormSubmit(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    Contact::create($validated);

    return redirect('/kontakt')->with('success', 'Wiadomość została wysłana!');
}
}
