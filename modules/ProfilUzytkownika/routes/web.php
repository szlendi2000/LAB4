<?php

use Illuminate\Support\Facades\Route;
use Modules\ProfilUzytkownika\Http\Controllers\ProfilUzytkownikaController;

Route::prefix('profil')->group(function () {
    Route::get('panel', [ProfilUzytkownikaController::class, 'index'])->name('profil.panel');
    Route::post('panel/toggle', [ProfilUzytkownikaController::class, 'toggleComponent'])->name('profil.panel.toggle');
});
