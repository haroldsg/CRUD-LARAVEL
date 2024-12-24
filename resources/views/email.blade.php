@extends('layout.form')

@section('form')

<h2>Send a Message</h2>

    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/sendEmail">
        @csrf

        <div>
            <label for="receiver_email">Recipient Email:</label>
            <input 
                type="email" 
                id="receiver_email" 
                name="receiver_email" 
                value="{{ old('receiver_email') }}" 
                required>
        </div>

        <div>
            <label for="message">Message:</label>
            <textarea 
                id="message" 
                name="message" 
                rows="4" 
                required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn">Send</button>
    </form>
@endsection

