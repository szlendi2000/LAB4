<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Modules\ModuleManager;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Wyświetla aktywne komponenty na profilu użytkownika.
     */
    public function components()
    {
        $moduleManager = app(ModuleManager::class);
        $moduleManager->loadModules();

        // Pobierz tylko włączone komponenty
        $components = $moduleManager->getEnabledComponents();

        return view('profil', compact('components'));
    }

    /**
     * Wyświetla panel zarządzania komponentami z listą wszystkich komponentów (włączonych i wyłączonych).
     */
    public function panel(ModuleManager $moduleManager)
    {
        $moduleManager->loadModules();

        // Pobierz WSZYSTKIE komponenty, aby można nimi zarządzać
        $components = $moduleManager->getAllComponents();

        return view('profil.panel', compact('components'));
    }

    /**
     * Aktualizuje stan włączania/wyłączania komponentów na podstawie formularza panelu.
     */
    public function updateComponents(Request $request, ModuleManager $moduleManager)
    {
        $moduleManager->loadModules();

        // Pobierz wszystkie komponenty
        $components = $moduleManager->getAllComponents();

        // Tablica komponentów przesłana w formularzu, np. components[modul.slug.component.slug] = on
        $inputComponents = $request->input('components', []);

        foreach ($components as $key => $component) {
            if (isset($inputComponents[$key])) {
                $component->enable();  // metoda enable() powinna zapisać zmianę w bazie
            } else {
                $component->disable(); // metoda disable() powinna zapisać zmianę w bazie
            }
        }

        return redirect()->route('profil.panel')->with('status', 'Zmiany zostały zapisane.');
    }

    public function toggleComponentsBatch(Request $request, ModuleManager $moduleManager)
{
    $request->validate([
        'enabled_components' => 'array',
        'enabled_components.*' => 'string',
    ]);

    $enabledSlugs = $request->input('enabled_components', []);

    $moduleManager->loadModules();

    $allComponents = $moduleManager->getAllComponents();

    foreach ($allComponents as $slug => $component) {
        if (in_array($slug, $enabledSlugs)) {
            $moduleManager->enableComponent($slug);
        } else {
            $moduleManager->disableComponent($slug);
        }
    }

    return redirect()->route('profil.panel')->with('status', 'Statusy komponentów zostały zaktualizowane.');
}

}
