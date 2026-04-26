<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Estúdio de Maquiagem</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<header style="display:flex; justify-content:space-between; padding:20px;">
    <a href="/" style="
    text-decoration: none; 
        background-color: #e6b0a2; 
        color: white; 
        padding: 10px 25px; 
        display: inline-block;
    ">Home</a>
</header>

@yield('content')

</body>
</html>