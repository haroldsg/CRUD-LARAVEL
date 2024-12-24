@extends('layout.form')

@section('form')
    <h2>Register your account</h2>

    <form method="POST" action="/user" id="phoneForm">
        @csrf
        <input type="text" name="name" placeholder="Enter name" required>
        <input type="email" name="email" placeholder="Enter email" required>
        <input type="password" name="password" placeholder="Enter password" required>

        <div>
            <input type="tel" name="phone_numbers[]" class="phone-input" required>
            <button type="button" id="btn-add-number" class="btn">+Add</button>
            <button type="button" id="btn-remove-number" class="btn">-Remove</button>
        </div>
        
        <div id="phoneContainer">

        </div>
        <input type="submit" name="submit" value="Submit" class="sub">
    </form>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
@endsection
