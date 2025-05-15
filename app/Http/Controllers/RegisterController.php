<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Register a new product
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'product' => 'required|string|max:300',
            'amount' => 'required|integer|min:1|max:30000',
            'description' => 'nullable|string|max:450',
            'price' => 'required|numeric|min:0.01|max:3000'
        ]);

        try {
            // Criação do produto no banco de dados
            $product = Product::create([
                'name' => $validatedData['product'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price']
            ]);

            // Resposta de sucesso
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);

        } catch (\Exception $e) {
            // Resposta de erro
            return response()->json([
                'success' => false,
                'message' => 'Failed to register product',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
