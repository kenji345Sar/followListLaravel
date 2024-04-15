<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRelationController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user-relations', [UserRelationController::class, 'index']);

Route::get('/user-10-relations', [UserRelationController::class, 'showUser10Relations']);

