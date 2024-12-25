<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="This is a sample API"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="login",
     *     description="user login",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", example="application/json"),
     *         description="Accept header"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", example="test@email.com"),
     *             @OA\Property(property="password", type="string", example="12345678"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="access_token", type="string", example="4|dplq1VfZkuLD9xMnh9aeBjVVLpZzXDQXC4L63w7De78c314c"),
     *                 @OA\Property(property="token_type", type="string", example="Bearer"),
     *             ),
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ApiResponse::sendResponse(['access_token' => $token, 'token_type' => 'Bearer']);
        }

        return ApiResponse::sendResponse(['message' => 'Invalid credentials'], code: 401);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="logout",
     *     description="user logout",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", example="application/json"),
     *         description="Accept header"
     *     ),
     *      @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", example="Bearer {token}"),
     *         description="Authorization header"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="access_token", type="string", example="4|dplq1VfZkuLD9xMnh9aeBjVVLpZzXDQXC4L63w7De78c314c"),
     *                 @OA\Property(property="token_type", type="string", example="Bearer"),
     *             ),
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ApiResponse::sendResponse(['message' => 'Logged out successfully']);
    }
}
