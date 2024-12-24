@extends('layout.mailBoxLayout')

@section('mailBox')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1 id="h1-mailBox">Your Mailbox</h1>
    
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                alert("{{ session('success') }}");
            });
        </script>
    @endif
    
    @if($messages->isEmpty())
        <p>No messages found.</p>
    @else
        <ul>
            @foreach ($messages as $message)
                <li>
                    <strong>From:</strong> {{ $message->sender->email }}
                    <br>
                    <strong>Message:</strong> {{ $message->message }}
                    <br>
                    <small>Sent at: {{ $message->created_at }}</small>
                    <button class="btn-read" data-message-id="{{ $message->id }}">Read</button>
                </li>
            @endforeach
        </ul>
    @endif
    
@endsection