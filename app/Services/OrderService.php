<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function storeOrder(array $data, int $cashierId)
    {
        return DB::transaction(function () use ($data, $cashierId) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($data['items'] as $item) {
                $product = Product::where('id', $item['product_id'])->lockForUpdate()->firstOrFail();

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok untuk produk {$product->name} tidak mencukupi.");
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $product->decrement('stock', $item['quantity']);

                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $discount = $data['discount'] ?? 0;
            $taxRate = 0.11;
            $tax = ($subtotal - $discount) * $taxRate;
            $grandTotal = ($subtotal - $discount) + $tax;

            $order = Order::create([
                'invoice_number' => 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(4)),
                'cashier_id' => $cashierId,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'status' => 'pending',
            ]);

            foreach ($itemsData as $item) {
                $order->items()->create($item);
            }

            return $order->load('items.product');
        });
    }
}