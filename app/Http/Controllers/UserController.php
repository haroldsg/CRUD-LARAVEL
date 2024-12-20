<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newUser = session('new_user'); // Obtener el usuario desde la sesión.

        // Pasar el usuario a la vista
        return view('index', compact('newUser'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());

        // Guardar el usuario en la sesión
        session(['new_user' => $user]);
    
        // Redirigir al índice
        return redirect('/user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        return view('user.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());
        session(['new_user' => $user]);
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Eliminar el usuario de la base de datos
        User::whereId($id)->delete();

        // Olvidar el usuario de la sesión
        session()->forget('new_user');
        
        // Redirigir al listado de usuarios
        return redirect('/user');
    }

    public function logout()
    {
        session()->forget('new_user');
        return redirect('/user');
    }
}
