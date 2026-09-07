<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Produto;
use App\Services\CheckoutService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdutoController extends Controller
{
    public function __construct(private readonly ProductService $products, private readonly CheckoutService $checkout) {}

    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $products = $this->products->list();
        $cartProducts = $this->products->cart($cart);

        return view('dashboard', [
            'products' => $products,
            'cartProducts' => $cartProducts,
            'cartTotal' => $cartProducts->sum('cart_subtotal'),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->products->create(
            $request->toData($request->user()->id),
            $request->file('photo'),
        );

        return redirect()
            ->route('dashboard')
            ->with('success', 'Produto cadastrado com sucesso.');
    }

    public function addToCart(AddToCartRequest $request, Produto $produto): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $cart[$produto->id] = min(99, ($cart[$produto->id] ?? 0) + $request->integer('quantity'));
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Produto adicionado ao carrinho.');
    }

    public function removeFromCart(Request $request, Produto $produto): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$produto->id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Produto removido do carrinho.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cartProducts = $this->products->cart($request->session()->get('cart', []));

        if ($cartProducts->isEmpty()) {
            return back()->withErrors(['cart' => 'Seu carrinho está vazio.']);
        }

        $this->checkout->checkout($request->user(), $cartProducts);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Compra realizada com sucesso.');
    }
}
