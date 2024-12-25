<?php

namespace App\Interfaces\Interfaces;

use App\Models\Cart;
use App\Models\Product;

interface CartRepositoryInterface
{
    public function createNewCart();

    public function attachProduct(Cart $cart, Product $product);

    public function detachProduct(Cart $cart, Product $product);

    public function productAttachmentExists(Cart $cart, Product $product);

    public function loadRelatedProducts(Cart $cart);

    public function getAll();
}
