@extends('layout.form')

@section('form')
    <h2>Edit your account</h2>

    <form method="POST" action="/user/{{$newUser->id}}" id="phoneForm">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <input type="text" name="name" placeholder="Enter name" value="{{$newUser->name}}" required>
        <input type="email" name="email" placeholder="Enter email" value="{{$newUser->email}}" required>
        <input type="password" name="password" placeholder="Enter password">

        <button type="button" id="btn-add-number" class="btn">+Add Number</button>
        <button type="button" id="btn-remove-number" class="btn">-Remove</button>
        <div id="phoneContainer">
            @foreach ($newUser->cellphones as $cellphone)
                <input type="tel" name="phone_numbers[]" class="phone-input" value="{{ $cellphone->phone_number }}" required>
            @endforeach
        </div>


        <input type="submit" name="submit" value="Submit" class="sub">
    </form>
@endsection

