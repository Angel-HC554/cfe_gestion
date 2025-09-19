<?php

use App\Http\Controllers\OrdenVehiculoController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//Route::resource('ordenvehiculos', OrdenVehiculoController::class)->except(
    //['show', 'destroy']);

Route::get('/ordenvehiculos/{id}/descargar',[OrdenVehiculoController::class, 'generarOrden'])->name('ordenvehiculos.descargar');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::resource('ordenvehiculos', OrdenVehiculoController::class)->except(
    ['show', 'destroy']);
});

require __DIR__.'/auth.php';
