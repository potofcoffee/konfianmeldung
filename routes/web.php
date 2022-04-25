<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\SetupController;

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

require __DIR__.'/auth.php';


Route::group(['prefix' => 'setup', 'as' => 'setup.'], function (){
    Route::get('/', [SetupController::class, 'index'])->name('index');
    Route::post('/gemeinde', [SetupController::class, 'church'])->name('church');
    Route::get('/gemeinde/{church:name}/gruppen', [SetupController::class, 'groups'])->name('groups');
    Route::post('/gemeinde/{church:name}/gruppen', [SetupController::class, 'storeGroups'])->name('groups.store');
});
