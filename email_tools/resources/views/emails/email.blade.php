<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Us</h1>
    <form method="post" action="{{ route('send.email') }}">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="subject">Subject:</label>
        <input type="text" name="subject" required>
        <br>
        <label for="message">Message:</label>
        <textarea name="message" required></textarea>
        <br>
        <button type="submit">Send Email</button>
    </form>
</body>
</html>
