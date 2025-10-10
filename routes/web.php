<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdenVehiculoController;
use App\Http\Controllers\VehiculoController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->user() ? view('dashboard') : redirect('login');//revisar
});
Route::resource('users',UserController::class);
//Route::resource('ordenvehiculos', OrdenVehiculoController::class)->except(
    //['show', 'destroy']);
Route::get('/ordenvehiculos/{id}/pdf', [OrdenVehiculoController::class, 'generatePdf'])->name('ordenvehiculos.pdf');

Route::get('/ordenvehiculos/{id}/generar',[OrdenVehiculoController::class, 'generarOrden'])->name('ordenvehiculos.generar');

// Descargas de escaneos (entrada/salida)
Route::get('/ordenvehiculos/{id}/escaneo/entrada', [OrdenVehiculoController::class, 'descargarEscaneoEntrada'])->name('ordenvehiculos.escaneo.entrada');
Route::get('/ordenvehiculos/{id}/escaneo/salida', [OrdenVehiculoController::class, 'descargarEscaneoSalida'])->name('ordenvehiculos.escaneo.salida');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::resource('ordenvehiculos', OrdenVehiculoController::class)->except(
    ['destroy']);
    Route::resource('vehiculos',VehiculoController::class);
});

require __DIR__.'/auth.php';
