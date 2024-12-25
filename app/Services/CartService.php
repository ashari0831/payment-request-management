<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Interfaces\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(public CartRepositoryInterface $cartRepositoryInterface)
    {
    }

    public function getAll()
    {
        return $this->cartRepositoryInterface->getAll();
    }

    public function loadRelatedProducts(Cart $cart)
    {
        $this->cartRepositoryInterface->loadRelatedProducts($cart);
    }

    public function attachProduct(Product $product)
    {
        DB::beginTransaction();
        try {
            if ($product->stock_quantity <= 0)
                throw new \Exception('Product is out of stock or has insufficient quantity.');

            $authUserCart = auth()->user()->cart()->first();

            if (is_null($authUserCart))
                $authUserCart = $this->cartRepositoryInterface->createNewCart();

            if ($this->cartRepositoryInterface->productAttachmentExists($authUserCart, $product))
                throw new \Exception('Product Exists in The Cart', 400);

            $this->cartRepositoryInterface->attachProduct($authUserCart, $product);

            DB::commit();

        } catch (\Exception $e) {
            ApiResponse::rollback($e, $e->getMessage(), $e->getCode());
        }
    }

    public function detachProduct(Cart $cart, Product $product)
    {
        DB::beginTransaction();
        try {
            $this->cartRepositoryInterface->detachProduct($cart, $product);

            DB::commit();

        } catch (\Exception $e) {
            ApiResponse::rollback($e);
        }
    }
}
