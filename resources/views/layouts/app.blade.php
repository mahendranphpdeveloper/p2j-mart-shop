<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0qz7zZ3Tz5P1p52nD2seuh0V3ST22x2jmK6rH2R2xul2xP9C" crossorigin="anonymous"></script>

</head>

<body>

    <!-- Include the header partial -->
    @include('layouts.header')

    <div class="custom-container">
        <!-- Main content will be injected here -->
        @yield('content')
    </div>

    <!-- Include the footer partial -->
    @include('layouts.footer')

</body>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0qz7zZ3Tz5P1p52nD2seuh0V3ST22x2jmK6rH2R2xul2xP9C" crossorigin="anonymous"></script>

</html>
