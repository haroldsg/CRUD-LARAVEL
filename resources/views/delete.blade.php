@extends('layout.form')

@section('form')
    <h2>Are you sure wanna ELIMINATED ACCOUNT</h2>
    <form method="POST" action="/user/{{$newUser->id}}">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="DELETE" class="sub">
    </form>
@endsection

