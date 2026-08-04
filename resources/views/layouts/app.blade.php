<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Estúdio de Maquiagem</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<header style="display:flex; justify-content:space-between; padding:20px;">
    <a href="/" style="
    text-decoration: none; 
        background-color: #e6b0a2; 
        color: white; 
        padding: 10px 25px; 
        display: inline-block;">Home</a>

    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="
                text-decoration: none;
                background-color: #e6b0a2;
                color: white;
                padding: 10px 25px;
                border: none;
                cursor: pointer;
                font-size: 1rem;">
                Sair
            </button>
        </form>
    @endauth
</header>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>