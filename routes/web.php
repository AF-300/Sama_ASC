<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JoueurController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ContributeurController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin + coach : gestion joueurs, matchs (creation/modif/suppr), annonces, statistiques
    // IMPORTANT : ce groupe doit etre declare AVANT le groupe public,
    // pour que "matchs/create" et "annonces/create" ne soient pas intercepte par "{match}"/"{annonce}"
    Route::middleware('role:admin_asc|coach')->group(function () {
        Route::resource('joueurs', JoueurController::class);
        Route::resource('matchs', MatchController::class)->except(['index', 'show']);
        Route::get('matchs/{match}/composition', [MatchController::class, 'composition'])->name('matchs.composition');
        Route::post('matchs/{match}/composition', [MatchController::class, 'storeComposition'])->name('matchs.composition.store');
        Route::get('matchs/{match}/statistiques', [StatistiqueController::class, 'edit'])->name('statistiques.edit');
        Route::post('matchs/{match}/statistiques', [StatistiqueController::class, 'update'])->name('statistiques.update');
        Route::resource('annonces', AnnonceController::class)->except(['index', 'show']);
    });

    // Accessible a tous les roles connectes (lecture seule)
    Route::middleware('role:admin_asc|coach|joueur|supporter')->group(function () {
        Route::resource('matchs', MatchController::class)->only(['index', 'show']);
        Route::resource('annonces', AnnonceController::class)->only(['index', 'show']);
        Route::get('classement', [StatistiqueController::class, 'classement'])->name('statistiques.classement');
        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{user}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('messages/{user}', [MessageController::class, 'store'])->name('messages.store');
        Route::post('notifications/marquer-lues', function () {
            auth()->user()->unreadNotifications->markAsRead();
            return back();
        })->name('notifications.marquer-lues');
        Route::get('mes-convocations', [MatchController::class, 'mesConvocations'])->name('matchs.mes-convocations');
    });

    // Admin uniquement : finances
    Route::middleware('role:admin_asc')->group(function () {
        Route::resource('cotisations', CotisationController::class);
        Route::resource('depenses', DepenseController::class);
        Route::get('caisse', [CaisseController::class, 'index'])->name('caisse.index');
        Route::resource('contributeurs', ContributeurController::class);
        Route::get('caisse/rapport-pdf', [CaisseController::class, 'exporterPdf'])->name('caisse.rapport-pdf');
    });
});

require __DIR__.'/auth.php';