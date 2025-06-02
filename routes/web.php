<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use WhichBrowser\Parser;
use App\Http\Controllers\ModuleController;
use App\Modules\ModuleManager;
use Modules\ProfilUzytkownika\Http\Controllers\ComponentsController;

Route::get('/admin/modules/install', [ModuleController::class, 'showInstallForm'])->name('modules.install.form');
Route::post('/admin/modules/install', [ModuleController::class, 'install'])->name('modules.install');
Route::get('/admin/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::post('/admin/modules/{slug}/enable', [ModuleController::class, 'enable'])->name('modules.enable');
Route::post('/admin/modules/{slug}/disable', [ModuleController::class, 'disable'])->name('modules.disable');
Route::post('/profil/panel/toggle-components', [ProfileController::class, 'toggleComponentsBatch'])->name('profil.panel.toggleComponentsBatch');
Route::get('/test-observer', function (ModuleManager $moduleManager) {
    $moduleManager->loadModules();
    $moduleManager->notifyComponents('test.event', ['message' => 'Test event z HTTP']);
    return 'Event "test.event" wysłany do komponentów, sprawdź logi lub output.';
});
Route::get('/user-agent', function (Request $request) {
    $parser = new Parser($request->header('User-Agent'));
    return [
        'browser' => $parser->browser->name,
        'os' => $parser->os->name,
    ];
});
Route::get('/', [PageController::class, 'home']);
Route::get('/kontakt', [PageController::class, 'kontakt']);
Route::get('/oferta', [PageController::class, 'oferta']);
Route::middleware('auth')->get('/profil/pytania', [PageController::class, 'pytania'])->name('profil.pytania');
Route::middleware('auth')->get('/profil/ankiety', [PageController::class, 'ankiety'])->name('profil.ankiety');
Route::middleware('auth')->get('/profil/dane', [PageController::class, 'dane'])->name('profil.dane');
Route::get('/logowanie', [PageController::class, 'logowanie']);
Route::middleware('auth')->get('/profil', [PageController::class, 'profil'])->name('profil');
Route::post('/kontakt', [PageController::class, 'kontaktFormSubmit']);
Route::redirect('/logowanie', '/login');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profil/panel', [ProfileController::class, 'panel'])->name('profil.panel');
    Route::post('/profil/panel', [ProfileController::class, 'updateComponents'])->name('profil.panel.update');
});

Route::get('/profil/komponenty', [ProfileController::class, 'components'])->name('profil.komponenty');

Route::prefix('profil/components')->group(function () {
    Route::get('/', [ComponentsController::class, 'index'])->name('profil.components.index');
    Route::post('/toggle', [ComponentsController::class, 'toggle'])->name('profil.components.toggle');
});

require __DIR__.'/auth.php';
