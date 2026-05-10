<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Darurat LearnLoop</title>
</head>
<body style="font-family: sans-serif; padding: 50px;">

    <h2>Login Darurat (Backend Testing)</h2>

    @if ($errors->any())
        <div style="background: red; color: white; padding: 10px; margin-bottom: 15px;">
            <strong>Woi Error:</strong> {{ $errors->first() }}
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf 

        <div>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </div>
        <br>
        <div>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        <br>
        <button type="submit">Gass Login!</button>
    </form>

</body>
</html>