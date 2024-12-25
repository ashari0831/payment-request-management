<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreProductRequest;
use App\Models\User;
use App\Notifications\ProductCreated;
use App\Services\ProductService;


class ProductController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Store a new product",
     *     description="Creates a new product and notifies the admin",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", example="application/json"),
     *         description="Accept header"
     *     ),
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", example="Bearer {token}"),
     *         description="Authorization header"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Product Name"),
     *             @OA\Property(property="description", type="string", example="Product Description"),
     *             @OA\Property(property="price", type="number", format="int", example=10000),
     *             @OA\Property(property="stock_quantity", type="number", format="int", example=50),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="name"),
     *                 @OA\Property(property="description", type="string", example="desc"),
     *                 @OA\Property(property="price", type="number", format="int", example=10000),
     *                 @OA\Property(property="stock_quantity", type="number", format="int", example=50),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-25T15:59:42.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-25T15:59:42.000000Z")
     *             ),
     *             @OA\Property(property="message", type="string", example="Product Create Successful")
     *         )
     *     )
     * )
     */
    public function store(StoreProductRequest $request, ProductService $productService)
    {
        $product = $productService->storeProduct($request->validated());

        $user = User::role('admin')->first();

        $user->notify(new ProductCreated($product));

        return ApiResponse::sendResponse($product, 'Product Create Successful', 201);
    }
}
