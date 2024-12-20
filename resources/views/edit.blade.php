@extends('layout.form')

@section('form')
    <h2>Register your account</h2>

    <form method="POST" action="/user/{{$newUser->id}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <input type="text" name="name" placeholder="Enter name" value="{{$newUser->name}}">
        <input type="email" name="email" placeholder="Enter email" value="{{$newUser->email}}">
        <input type="password" name="password" placeholder="Enter password">
        <input type="submit" name="submit" value="Submit" class="sub">
    </form>
@endsection