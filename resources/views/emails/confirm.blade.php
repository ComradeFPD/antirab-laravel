
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Активация нового пользователя</title>
</head>
<body>
<h1>Спасибо за регистрацию!</h1>
<p>
    Перейдите <a href="{{url("register/confirm/{$user->token}")}}">по этой ссылке</a>
</p>
</body>
</html>
