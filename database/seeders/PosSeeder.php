<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Kasir Default
        $cashier = User::firstOrCreate(
            ['email' => 'kasir@pos.com'],
            [
                'name' => 'Kasir Utama',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Buat Data Produk
        $products = [
            ['name' => 'Kopi Espresso 250g', 'sku' => 'PRD-001', 'price' => 75000, 'stock' => 50],
            ['name' => 'Milk Frother Elektrik', 'sku' => 'PRD-002', 'price' => 150000, 'stock' => 20],
            ['name' => 'Gelas Ceramic Mug', 'sku' => 'PRD-003', 'price' => 35000, 'stock' => 100],
            ['name' => 'Coffee Dripper V60', 'sku' => 'PRD-004', 'price' => 95000, 'stock' => 30],
        ];

        foreach ($products as $prod) {
            Product::firstOrCreate(['sku' => $prod['sku']], $prod);
        }

        // 3. Buat Data Transaksi Selesai untuk Grafik Pendapatan Bulanan
        $productSample = Product::first();
        for ($i = 1; $i <= 5; $i++) {
            $subtotal = $productSample->price * 2;
            $tax = $subtotal * 0.11;
            
            Order::create([
                'invoice_number' => 'INV/2026060' . $i . '/' . strtoupper(Str::random(4)),
                'cashier_id' => $cashier->id,
                'subtotal' => $subtotal,
                'discount' => 5000,
                'tax' => $tax,
                'grand_total' => ($subtotal - 5000) + $tax,
                'status' => 'completed',
                'created_at' => now()->subMonths(6 - $i), // Tanggal mundur per bulan untuk grafik
                'updated_at' => now()->subMonths(6 - $i),
            ]);
        }
    }
}