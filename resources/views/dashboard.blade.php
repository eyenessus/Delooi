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
<body class="bg-white">
    <main class="container py-4">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Produtos</h1>
                <p>Olá, {{ auth()->user()->name }}.</p>
            </div>
            <a href="{{ route('dashboard') }}">Atualizar</a>
        </header>

        @if (session('success'))
            <div role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <section aria-labelledby="new-product-title">
            <h2 id="new-product-title">Cadastrar produto</h2>
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <label for="name">Nome</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required>

                <label for="price">Preço</label>
                <input id="price" name="price" type="number" min="0.01" step="0.01" value="{{ old('price') }}" required>

                <label for="photo">Foto</label>
                <input id="photo" name="photo" type="file" accept="image/*">
                <button type="submit">Cadastrar produto</button>
            </form>
        </section>

        <section aria-labelledby="products-title">
            <h2 id="products-title">Produtos disponíveis</h2>
            @forelse ($products as $product)
                <article>
                    @if ($product->photo)
                        <img src="{{ asset('storage/' . $product->photo) }}" alt="Foto de {{ $product->name }}" width="180">
                    @endif
                    <h3>{{ $product->name }}</h3>
                    <p>Vendido por {{ $product->user?->name ?? 'Usuário' }}</p>
                    <strong>R$ {{ number_format($product->price, 2, ',', '.') }}</strong>
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <label for="quantity-{{ $product->id }}">Quantidade</label>
                        <input id="quantity-{{ $product->id }}" name="quantity" type="number" min="1" max="99" value="1" required>
                        <button type="submit">Adicionar ao carrinho</button>
                    </form>
                </article>
            @empty
                <p>Nenhum produto cadastrado ainda.</p>
            @endforelse
        </section>

        <section aria-labelledby="cart-title">
            <h2 id="cart-title">Meu carrinho</h2>
            @forelse ($cartProducts as $product)
                <div>
                    <span>{{ $product->name }} x {{ $product->cart_quantity }}</span>
                    <strong>R$ {{ number_format($product->cart_subtotal, 2, ',', '.') }}</strong>
                    <form method="POST" action="{{ route('cart.remove', $product) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remover</button>
                    </form>
                </div>
            @empty
                <p>Seu carrinho está vazio.</p>
            @endforelse

            @if ($cartProducts->isNotEmpty())
                <p>Total: <strong>R$ {{ number_format($cartTotal, 2, ',', '.') }}</strong></p>
                <form method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <button type="submit">Finalizar compra</button>
                </form>
            @endif
        </section>
    </main>
</body>
</html>
