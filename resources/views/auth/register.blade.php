{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register with Google</h2>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name" value="{{ session('google_name') }}"><br><br>
        <input type="email" name="email" placeholder="Email" value="{{ session('google_email') }}"><br><br>
        <input type="text" name="phone" placeholder="Phone"><br><br>
        <input type="hidden" name="google_id" value="{{ session('google_id') }}">
        <button type="submit">Register</button>
    </form>
</body>
</html>
