<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_unit_id')->nullable();
            $table->integer('qty');
            $table->timestamp('expires_at');
            $table->enum('status', ['reserved', 'confirmed', 'released'])->default('reserved');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('stock_reservations');
    }
};
