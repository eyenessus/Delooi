<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

</head>

<body class="bg-light">
    <main class="container min-vh-100 d-flex align-items-center py-4">
        <div class="row justify-content-center w-100">
            <div class="col-sm-10 col-md-7 col-lg-5 col-xl-4">
                <section class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h2 text-center mb-4">Login em Delooi</h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                        <p class="text-center text-secondary mb-0 mt-4">
                            Não tem uma conta?
                            <a href="{{ route('signup') }}">Cadastre-se</a>
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </main>

</body>

</html>
