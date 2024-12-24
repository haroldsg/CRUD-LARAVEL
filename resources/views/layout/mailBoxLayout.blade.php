<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Document')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div id="top-bar">
        <img src="https://cdn-icons-png.freepik.com/512/14026/14026645.png" id="icon-house">
        <button id="btn-send-email" class="btn-bar">Send email</button>
    </div>

    <div id="mailBox">
        @yield('mailBox')
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script> <!-- Si tienes un archivo app.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    
    <!--Need create a rute of blade 
    <script>const createUserUrl = "{{ url('user/create') }}";</script> -->
</body>
</html>
