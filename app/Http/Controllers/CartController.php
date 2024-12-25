<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;


class CartController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/carts",
     *     summary="List carts",
     *     description="List carts",
     *     tags={"Carts"},
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
     * @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(
     *                     property="products",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="product1"),
     *                         @OA\Property(property="description", type="string", example="desc"),
     *                         @OA\Property(property="price", type="number", format="int", example=5000),
     *                         @OA\Property(property="stock_quantity", type="integer", example=10),
     *                         @OA\Property(property="image_url", type="string", nullable=true, example=null),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-25T09:58:53.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-25T09:58:53.000000Z"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="cart_id", type="integer", example=1),
     *                             @OA\Property(property="product_id", type="integer", example=1)
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="admin"),
     *                     @OA\Property(property="email", type="string", example="mehefil951@owube.com"),
     *                     @OA\Property(property="email_verified_at", type="string", nullable=true, example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-24T16:45:20.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-24T16:45:20.000000Z")
     *                 ),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-25T12:37:05.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-25T12:37:05.000000Z")
     *             )
     *         )
     *     )
     * )
     * )
     */
    public function index(CartService $cartService)
    {
        $carts = $cartService->getAll();

        return ApiResponse::sendResponse(CartResource::collection($carts));
    }

    /**
     * @OA\Get(
     *     path="/api/carts/{cart}",
     *     summary="Show a cart",
     *     description="Show a cart",
     *     tags={"Carts"},
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
     *     @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(
     *             property="data",
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="product1"),
     *                     @OA\Property(property="description", type="string", example="desc"),
     *                     @OA\Property(property="price", type="number", format="int", example=5000),
     *                     @OA\Property(property="stock_quantity", type="integer", example=10),
     *                     @OA\Property(property="image_url", type="string", nullable=true, example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-25T09:58:53.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-25T09:58:53.000000Z"),
     *                     @OA\Property(
     *                         property="pivot",
     *                         type="object",
     *                         @OA\Property(property="cart_id", type="integer", example=1),
     *                         @OA\Property(property="product_id", type="integer", example=1)
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="admin"),
     *                 @OA\Property(property="email", type="string", example="mehefil951@owube.com"),
     *                 @OA\Property(property="email_verified_at", type="string", nullable=true, example=null),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-24T16:45:20.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-24T16:45:20.000000Z")
     *             ),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-25T12:37:05.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-25T12:37:05.000000Z")
     *         )
     *     )
     * )
     * )
     */
    public function show(Cart $cart, CartService $cartService)
    {
        $cartService->loadRelatedProducts($cart);

        return ApiResponse::sendResponse(new CartResource($cart));
    }

    /**
     * @OA\Post(
     *     path="/api/carts/products/{product}/attach",
     *     summary="Attach product to cart",
     *     description="Attach product to cart",
     *     tags={"Carts"},
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
     *     @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="data", type="string", example="Cart Product Attach Successful")
     *     )
     * )
     * )
     */
    public function attachProduct(Product $product, CartService $cartService)
    {
        $cartService->attachProduct($product);

        return ApiResponse::sendResponse('Cart Product Attach Successful', '', 200);
    }

    /**
     * @OA\Post(
     *     path="/api/carts/{cart}/products/{product}/attach",
     *     summary="Detach product from  cart",
     *     description="Detach product from a cart",
     *     tags={"Carts"},
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
     *     @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="data", type="string", example="Cart Product Detach Successful")
     *     )
     * )
     * )
     */
    public function detachProduct(Cart $cart, Product $product, CartService $cartService)
    {
        $cartService->detachProduct($cart, $product);

        return ApiResponse::sendResponse('Cart Product Detach Successful', '', 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user/cart",
     *     summary="Show auth user cart",
     *     description="Show auth user cart",
     *     tags={"Carts"},
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
     *     @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(
     *             property="data",
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="product1"),
     *                     @OA\Property(property="description", type="string", example="desc"),
     *                     @OA\Property(property="price", type="number", format="int", example=5000),
     *                     @OA\Property(property="stock_quantity", type="integer", example=10),
     *                     @OA\Property(property="image_url", type="string", nullable=true, example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-25T09:58:53.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-25T09:58:53.000000Z"),
     *                     @OA\Property(
     *                         property="pivot",
     *                         type="object",
     *                         @OA\Property(property="cart_id", type="integer", example=1),
     *                         @OA\Property(property="product_id", type="integer", example=1)
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="admin"),
     *                 @OA\Property(property="email", type="string", example="mehefil951@owube.com"),
     *                 @OA\Property(property="email_verified_at", type="string", nullable=true, example=null),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-24T16:45:20.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-24T16:45:20.000000Z")
     *             ),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-25T12:37:05.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-25T12:37:05.000000Z")
     *         )
     *     )
     * )
     * )
     */
    public function showAuthUserCart(CartService $cartService)
    {
        $cart = auth()->user()->cart()->first();

        $cartService->loadRelatedProducts($cart);

        return ApiResponse::sendResponse(new CartResource($cart));
    }
}
