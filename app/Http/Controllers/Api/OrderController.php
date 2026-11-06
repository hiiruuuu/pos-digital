<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
        ]);

        try {
            // Ambil ID user yang sedang login, atau fallback ke user pertama jika diakses via web tanpa login
            $cashierId = $request->user()?->id ?? \App\Models\User::first()->id ?? 1;

            $order = $this->orderService->storeOrder($request->all(), $cashierId);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil diproses',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
