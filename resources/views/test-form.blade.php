<form method="POST" action="{{ route('contact.submit') }}">
    @csrf
    <input type="text" name="name" value="Test Name">
    <input type="email" name="email" value="test@example.com">
    <input type="text" name="phone" value="1234567890">
    <textarea name="message">Test message</textarea>
    <button type="submit">Submit</button>
</form>