<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('price_caches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 15, 4);
            $table->timestamp('fetched_at');
            $table->json('raw_response')->nullable();
            $table->timestamps();

            $table->unique(['stock_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('price_caches');
    }
};
