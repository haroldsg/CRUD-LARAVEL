@extends('layout.form')

@section('form')
    <h2>Ingress your data</h2>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf
        <input type="email" name="email"  placeholder="Enter email" required>
        <input type="password" name="password"  placeholder="Enter password" required>
        <input type="submit" class="sub" value="Login">
    </form>
@endsection
