<!DOCTYPE html>
<html>

<head>
    <title>New Contact Form Submission</title>
</head>

<body>
    <h1>New Contact Form Submission</h1>
    <p>Name: {{ $data['name'] }}</p>
    <p>Email: {{ $data['email'] }}</p>
    <p>Message: {{ $data['message'] }}</p>
</body>

</html>