<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use App\Models\Product;

class CartRepository implements CartRepositoryInterface
{
    public function index()
    {
        return Cart::all();
    }

    public function getById($id)
    {
        return Cart::findOrFail($id);
    }

    public function createNewCart()
    {
        return auth()->user()->cart()->create([
            'status' => Cart::STATUS['pending'],
        ]);
    }

    public function attachProduct(Cart $cart, Product $product)
    {
        $cart->products()->attach($product);
    }

    public function detachProduct(Cart $cart, Product $product)
    {
        $cart->products()->detach($product);
    }

    public function productAttachmentExists(Cart $cart, Product $product)
    {
        return $cart->products()->where('product_id', $product->id)->exists();
    }

    public function loadRelatedProducts(Cart $cart)
    {
        $cart->load(['products', 'user']);
    }

    public function getAll()
    {
        return Cart::with('products')->get();
    }
}
