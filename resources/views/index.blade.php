@extends('layout.app')


@section('top-bar')
    @if(isset($newUser) != null)
        <button class="btn-bar" id="btn-close">Logout</button>
        <div id="right-buttons"> 
            @if($hasUnreadMessages)
                <img src="images\inbox-mail.png" class="icon-email">
            @else
                <img src="images\email.png" class="icon-email">
            @endif
            <button class="btn-bar" id="btn-edit">Edit account</button>
            <button class="btn-bar" id="btn-delete" data-user-id="{{ $newUser->id }}">Delete account</button>
        </div>
    @else
        <div>
            
        </div>
        <div id="right-buttons">
            <button class="btn-bar" id="btn-login">Login</button> 
            <button class="btn-bar" id="btn-register">Register</button>
        </div>
    @endif
    
@endsection



@section('welcome')
    
    <!--name is the name of the user created in UserController function store -->
    @if(isset($newUser) != null)
        <h1>Welcome  {{ $newUser->name }}</h1>
    @else
        <h1>Welcome user!</h1>
        <p>Please register :D</p>
    @endif

        

@endsection

