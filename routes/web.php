<?php

use Illuminate\Support\Facades\Route;
//controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OrdenController;





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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[App\Http\Controllers\OrdenController::class, 'index'])->name('LandingPage');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//agregado softdeletes
Route::get('/ordenes/archive', [OrdenController::class, 'archive']);

//Rutas 
Route::group(['middleware' => ['auth']], function(){
    Route::resource('roles',RolController::class);
    Route::resource('usuarios',UsuarioController::class);
    // Route::resource('ordenes',OrdenController::class);
    Route::resource('ordenes',OrdenController::class)->parameters(['ordenes' => 'order']);
    //agregado softdeletes
    Route::delete('/ordenes/{order}', [OrdenController::class, 'destroy'])->name('ordenes.destroy')->withTrashed();
    Route::post('/ordenes/{order}/restore', [OrdenController::class, 'restore'])->name('ordenes.restore')->withTrashed();

});





