<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delooi | Produtos</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-light">
    <main class="container py-4">
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="display-6 mb-1">Produtos</h1>
                <p class="text-secondary mb-0">Olá, {{ auth()->user()->name }}.</p>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Atualizar</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger" type="submit">Sair</button>
                </form>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <section class="card shadow-sm mb-4" aria-labelledby="new-product-title">
            <div class="card-body">
                <h2 id="new-product-title" class="h4 card-title mb-3">Cadastrar produto</h2>
                <form class="row g-3" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-5">
                        <label class="form-label" for="name">Nome</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="price">Preço</label>
                        <input class="form-control" id="price" name="price" type="number" min="0.01" step="0.01" value="{{ old('price') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="photo">Foto</label>
                        <input class="form-control" id="photo" name="photo" type="file" accept="image/*">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Cadastrar produto</button>
                    </div>
                </form>
            </div>
        </section>

        <section class="mb-4" aria-labelledby="products-title">
            <h2 id="products-title" class="h4 mb-3">Produtos disponíveis</h2>
            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-sm-6 col-lg-4">
                        <article class="card h-100 shadow-sm">
                            @if ($product->photo)
                                <img class="card-img-top object-fit-cover" style="height: 180px" src="{{ asset('storage/' . $product->photo) }}" alt="Foto de {{ $product->name }}">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h3 class="h5 card-title">{{ $product->name }}</h3>
                                <p class="text-secondary mb-2">Vendido por {{ $product->user?->name ?? 'Usuário' }}</p>
                                <strong class="fs-5 mb-3">R$ {{ number_format($product->price, 2, ',', '.') }}</strong>
                                <form class="mt-auto" method="POST" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <label class="form-label" for="quantity-{{ $product->id }}">Quantidade</label>
                                    <div class="input-group">
                                        <input class="form-control" id="quantity-{{ $product->id }}" name="quantity" type="number" min="1" max="99" value="1" required>
                                        <button class="btn btn-primary" type="submit">Adicionar ao carrinho</button>
                                    </div>
                                </form>
                            </div>
                        </article>
                    </div>
                @empty
                    <p class="text-secondary">Nenhum produto cadastrado ainda.</p>
                @endforelse
            </div>
        </section>

        <section class="card shadow-sm" aria-labelledby="cart-title">
            <div class="card-body">
                <h2 id="cart-title" class="h4 mb-3">Meu carrinho</h2>
            @forelse ($cartProducts as $product)
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 border-bottom py-3">
                    <span>{{ $product->name }} x {{ $product->cart_quantity }}</span>
                    <strong>R$ {{ number_format($product->cart_subtotal, 2, ',', '.') }}</strong>
                    <form method="POST" action="{{ route('cart.remove', $product) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Remover</button>
                    </form>
                </div>
            @empty
                <p class="text-secondary mb-0">Seu carrinho está vazio.</p>
            @endforelse

            @if ($cartProducts->isNotEmpty())
                <p class="fs-5 text-end mt-3">Total: <strong>R$ {{ number_format($cartTotal, 2, ',', '.') }}</strong></p>
                <form method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <button class="btn btn-success w-100" type="submit">Finalizar compra</button>
                </form>
            @endif
            </div>
        </section>
    </main>
</body>
</html>
