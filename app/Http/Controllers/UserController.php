<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\MailBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Prompts\Exceptions\FormRevertedException;

use function Laravel\Prompts\alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newUser = session('new_user'); // Obtener el usuario de la sesión

        // Verificar si hay mensajes no leídos
        $hasUnreadMessages = false;
        if ($newUser) {
            $hasUnreadMessages = MailBox::where('receiver_id', $newUser->id)
                ->where('is_read', false) // Cambia `is_read` según cómo manejes los mensajes no leídos
                ->exists();
        }

        return view('index', compact('newUser', 'hasUnreadMessages'));
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3',
            'phone_numbers' => 'required|array', 
            'phone_numbers.*' => 'required|string|max:15', 
        ], [
            'name.required' => 'The name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'It must be a valid email address.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 3 characters long.',
            'phone_numbers.required' => 'At least one phone number is required.',
            'phone_numbers.*.required' => 'Each phone number is required.',
            'phone_numbers.*.max' => 'Each phone number must not exceed 15 characters.'
        ]);
        
        $user = User::create([ 
            'name' => $validatedData['name'], 
            'email' => $validatedData['email'], 
            'password' => bcrypt($validatedData['password']), 
        ]);

        foreach ($validatedData['phone_numbers'] as $phoneNumber) {
            $user->cellphones()->create(['phone_number' => $phoneNumber]);
        }
        session(['new_user' => $user]);
    
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
         // Validar los datos entrantes
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id, // Permite el mismo email para el usuario actual
            'password' => 'nullable|min:3', // Contraseña opcional
            'phone_numbers' => 'required|array', // Asegura que los números de teléfono estén en un array
            'phone_numbers.*' => 'required|string|max:15', // Valida cada número de teléfono
        ]);

        // Buscar al usuario
            $user = User::findOrFail($id);

        // Actualizar datos básicos
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? bcrypt($request->input('password')) : $user->password,
        ]);

        // Actualizar números de teléfono
        // Primero eliminar los números existentes
        $user->cellphones()->delete();

        // Insertar nuevos números
        foreach ($request->input('phone_numbers') as $phone_number) {
            $user->cellphones()->create(['phone_number' => $phone_number]);
        }
        session(['new_user' => $user]);
        return redirect('/user');
    }

    
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

    public function showLogin()
    {
        return view('login');
    }


    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar el usuario por email
        $user = User::where('email', $credentials['email'])->first();

        // Verificar que el usuario exista y la contraseña sea correcta
        if ($user && password_verify($credentials['password'], $user->password)) {
            // Guardar información del usuario en la sesión
            session(['new_user' => $user]);

            // Redirigir al usuario después de iniciar sesión
            return redirect('/user');
        }

        // Si las credenciales no son válidas
        return back()->with('error', 'Incorrect credentials');
    }
    
    public function mailBox(){
        $user = session('new_user');
        $userId = $user->id;

        $messages = MailBox::where('receiver_id', $userId)->get();

        return view('mailBox', compact('messages'));
    }

    public function email(){

        return view('email');
    }

    public function sendEmail(Request $request)
    {
        // Validar el formulario
        $validated = $request->validate([
            'receiver_email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // Obtener el usuario autenticado o de sesión
        $user = session('new_user');
        $senderId = $user->id;

        // Verificar si el correo existe en la base de datos
        $receiver = User::where('email', $validated['receiver_email'])->first();

        if (!$receiver) {
            // Si el correo no existe, redirigir al formulario con un mensaje de error
            return redirect()->route('email.form')->withErrors(['receiver_email' => 'The recipient email does not exist in our database.']);
        }

        // Verificar si el usuario intenta enviarse un correo a sí mismo
        if ($user->email === $validated['receiver_email']) {
            return redirect()->route('email.form')->withErrors(['receiver_email' => 'You cannot send a message to yourself.']);
        }

        // Obtener el usuario autenticado o de sesión
        $user = session('new_user');
        $senderId = $user->id;

        // Guardar el mensaje en la base de datos
        MailBox::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiver->id,
            'message' => $validated['message'],
        ]);

        // Redirigir con éxito
        return redirect()->route('mailBox.form')->with('success', 'Message sent successfully!');
    }



    public function markAsRead(Request $request, $id)
    {
        $message = MailBox::find($id);

        if (!$message) {
            return response()->json(['error' => 'Message not found.'], 404);
        }

        // Marcar como leído
        $message->is_read = true;
        $message->save();

        return response()->json(['success' => 'Message marked as read.']);
    }

}
