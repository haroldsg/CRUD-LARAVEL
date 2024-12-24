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

Route::get('/showLogin', [UserController::class, 'showLogin'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login');


Route::post('/sendEmail', [UserController::class, 'sendEmail'])->name('email');

Route::get('/mailBox', [UserController::class, 'mailBox'])->name('mailBox.form');

Route::get('/email', function () {
    $user = session('user'); // Obtener el usuario de la sesión

    if (!$user) {
        $user = null; // Si no hay usuario en sesión, asignamos null
    }

    return view('email', ['user' => $user]);
})->name('email.form');

Route::post('/markAsRead/{id}', [UserController::class, 'markAsRead'])->name('markAsRead');
