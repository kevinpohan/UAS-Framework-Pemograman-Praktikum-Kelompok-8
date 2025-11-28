<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@tradeink.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'balance' => 10000,
        ]);

        // Create sample users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'balance' => 5000,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'balance' => 7500,
        ]);

        // Create sample stocks
        Stock::create([
            'symbol' => 'AAPL',
            'name' => 'Apple Inc.',
            'currency' => 'USD',
        ]);

        Stock::create([
            'symbol' => 'MSFT',
            'name' => 'Microsoft Corporation',
            'currency' => 'USD',
        ]);

        Stock::create([
            'symbol' => 'GOOGL',
            'name' => 'Alphabet Inc.',
            'currency' => 'USD',
        ]);

        Stock::create([
            'symbol' => 'TSLA',
            'name' => 'Tesla Inc.',
            'currency' => 'USD',
        ]);

        Stock::create([
            'symbol' => 'AMZN',
            'name' => 'Amazon.com Inc.',
            'currency' => 'USD',
        ]);

        Stock::create([
            'symbol' => 'NVDA',
            'name' => 'NVIDIA Corporation',
            'currency' => 'USD',
        ]);
    }
}
