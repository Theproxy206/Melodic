<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

// --- Rutas Públicas (Invitados) ---
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// --- Rutas Protegidas (Requieren Login) ---
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rutas de Suscripción (Accesibles aunque no pagues, para poder pagar)
    Route::get('/premium', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/premium', [SubscriptionController::class, 'store'])->name('subscription.store');

    // --- EL MURO DE PAGO (Requieren Login + Suscripción Activa) ---
    Route::middleware(['subscribed'])->group(function () {

        // 1. Dashboard de Usuario
        Route::get('/dashboard/user', [DashboardController::class, 'user'])
            ->middleware(['role:user'])
            ->name('dashboard.user');

        // 2. Dashboard de Artista
        Route::get('/dashboard/artist', [DashboardController::class, 'artist'])
            ->middleware(['role:artist'])
            ->name('dashboard.artist');

        // 3. Funciones de Artista (Subir música)
        Route::post('/album', [AlbumController::class, 'store'])
            ->middleware('role:artist')
            ->name('album.store');

        Route::post('/song', [SongController::class, 'store'])
            ->middleware('role:artist')
            ->name('song.store');

        // 4. Reproducción (Registrar $)
        Route::post('/song/{song}/play', [SongController::class, 'registerPlay'])
            ->name('song.play');

        // 5. Ver Álbumes (Público para todos los suscritos)
        Route::get('/album/{album}', [AlbumController::class, 'show'])
            ->name('album.show');

        // 6. Playlists (Lógica de Usuario)
        Route::get('/playlists', [PlaylistController::class, 'index'])
            ->name('playlists.index');

        Route::post('/playlist', [PlaylistController::class, 'store'])
            ->middleware('role:user')
            ->name('playlist.store');

        Route::get('/playlist/{playlist}', [PlaylistController::class, 'show'])
            ->name('playlist.show');

        Route::post('/playlist/{playlist}/add-song', [PlaylistController::class, 'addSong'])
            ->name('playlist.addSong');

        Route::post('/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

        // 7. Explorar
        Route::get('/explore', [DashboardController::class, 'explore'])
            ->name('explore');

        // 8. GRUPO LABEL (Disquera)
        Route::middleware(['role:label'])->group(function () {

            // Dashboard Label
            Route::get('/dashboard/label', [DashboardController::class, 'label'])
                ->name('dashboard.label');

            // Crear Artista
            Route::post('/label/create-artist', [LabelController::class, 'storeArtist'])
                ->name('label.create_artist');

            // Retirar Fondos (¡ESTA FALTABA!)
            Route::post('/label/withdraw', [LabelController::class, 'withdraw'])
                ->name('label.withdraw');
        });
    });
});
