<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// / route is moved in auth.php for the login route

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@dashboard' )->name('dashboard');

    Route::resource('/extensions', 'App\Http\Controllers\ExtensionsController')->names([
        'index'  => 'extensions.list',
        'show'   => 'extensions.show',
        'create' => 'extensions.create',
        'store'  => 'extensions.store',
        'edit'   => 'extensions.edit',
        'update' => 'extensions.update',
        'destroy'=> 'extensions.delete'
    ]);

    Route::get( '/extensions/{extension}/manifest', 'App\Http\Controllers\ExtensionsController@showManifest' )->name( 'extensions.view_manifest' );
    Route::post( '/extensions/{extension}/manifest', 'App\Http\Controllers\ExtensionsController@saveManifest' )->name( 'extensions.save_manifest' );
    Route::get( '/extensions/{extension}/upload', 'App\Http\Controllers\ExtensionsController@uploadExtensionFileForm' )->name( 'extensions.upload_form' );
    Route::post( '/extensions/{extension}/upload', 'App\Http\Controllers\ExtensionsController@uploadExtensionFile' )->name( 'extensions.upload' );

    Route::resource('/users', 'App\Http\Controllers\UsersController')->names([
        'index'  => 'users.list',
        'show'   => 'users.show',
        'create' => 'users.create',
        'store'  => 'users.store',
        'edit'   => 'users.edit',
        'update' => 'users.update',
        'destroy'=> 'users.delete'
    ]);

    Route::post( '/services/unique-value', 'App\Services\UtilityService@generate_unique_value' )->name('service.generate_unique_value');

    Route::resource('/requests', 'App\Http\Controllers\SiteRequestsController')->names([
        'index'  => 'requests.list',
        'show'   => 'requests.show',
        'create' => 'requests.create',
        'store'  => 'requests.store',
        'edit'   => 'requests.edit',
        'update' => 'requests.update',
        'destroy'=> 'requests.delete'
    ]);

    Route::post( '/requests/search', 'App\Http\Controllers\SiteRequestsController@searchRequest' )->name('requests.search');

});

Route::get( '/extension/{slug}', 'App\Http\Controllers\ExtensionsController@publicExtensionData' )->name( 'extensions.public' );

require __DIR__.'/auth.php';
