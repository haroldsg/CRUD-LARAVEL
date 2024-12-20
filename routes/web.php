<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::resource('/user',UserController::class);

Route::get('/delete', function () {
    $newUser = session('new_user');

    if (!$newUser) {
        return redirect('/user')->with('error', 'No hay usuario disponible para eliminar.');
    }

    return view('delete', ['newUser' => $newUser]);
})->name('delete');


Route::get('/edit', function () {
    $newUser = session('new_user');

    if (!$newUser) {
        return redirect('/user')->with('error', 'No hay usuario disponible para editar.');
    }

    return view('edit', ['newUser' => $newUser]);
})->name('edit');

Route::get('/logout', '\App\Http\Controllers\UserController@logout');
