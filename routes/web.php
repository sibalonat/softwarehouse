<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\GameController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\SalesPersonController;
use App\Http\Controllers\HumanResourcesController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // game resource
    Route::resource('/game', GameController::class);

    // game update name information
    Route::patch('/game/{game}/name', [GameController::class, 'updateName'])->name('game.updateName');

    // production page
    Route::name('production.')->group(function () {
        // projects page
        Route::resource('/production/projects', ProjectController::class)->except([
            'create', 'store', 'destroy'
        ]);
        // developers page
        Route::resource('/production/developers', DeveloperController::class)->except([
            'create', 'store', 'destroy'
        ]);
    });

    // sales page
    Route::resource('/sales', SalesPersonController::class);

    // human resource page
    Route::get('/hr/developers', [HumanResourcesController::class, 'developers'])->name('hr.developers');
    Route::get('/hr/salesforce', [HumanResourcesController::class, 'salesforce'])->name('hr.salesforce');

    // hire sales person
    Route::put('/hr/salesforce/{salesPerson}/hire', [
        HumanResourcesController::class, 'hireSalesPerson'
    ])->name('hr.salesforce.hire');
    // hire developer
    Route::put('/hr/developers/{developer}/hire', [
        HumanResourcesController::class, 'hireDeveloper'
    ])->name('hr.developer.hire');

});

require __DIR__.'/auth.php';
