<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <title>@yield('title', 'Game Collection')</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/games">Game Collection</a>

        <div class="navbar-nav">
            <a class="nav-item nav-link" href="/games">Games</a>
            <a class="nav-item nav-link" href="{{ route('admin.permissions.index') }}">
                Permissies beheren
            </a>
        </div>
    </nav>

    <div class="container" style="margin-top: 40px;">

        <h1 class="display-4">@yield('title')</h1>

        @yield('content')

    </div>

</body>
</html>