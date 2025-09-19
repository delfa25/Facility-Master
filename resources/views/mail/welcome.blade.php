<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenue sur Facility Master</title>
</head>
<body>
    
    <h1>Bonjour {{ $user['name'] }} </h1>
    <p>Nous sommes ravis de vous compter parmi nous.</p>
    <p>Vous pouvez vous connecter à votre compte en utilisant le lien ci-dessous :</p>
    <a href="{{ route('login') }}">Facility Master</a>

</body>
</html>