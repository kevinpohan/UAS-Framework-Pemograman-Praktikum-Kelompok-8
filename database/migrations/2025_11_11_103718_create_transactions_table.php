<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('stock_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['buy', 'sell', 'topup', 'withdraw']);
            $table->decimal('qty', 15, 4)->nullable();
            $table->decimal('price', 15, 4)->nullable();
            $table->decimal('total', 15, 2);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
