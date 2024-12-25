<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProductQuantity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = $request->route('product');

        if (!$product || $product?->stock_quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Not Enough Quantity.'
            ], 400);
        }

        return $next($request);
    }
}
