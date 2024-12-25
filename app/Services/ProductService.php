<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(public ProductRepositoryInterface $productRepositoryInterface)
    {
    }

    public function storeProduct($data)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->store($data);

            DB::commit();
            return new ProductResource($product);

        } catch (\Exception $e) {
            ApiResponse::rollback($e);
        }
    }
}
