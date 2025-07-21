<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Terhubung ke tabel categories
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->bigInteger('price'); // Pakai bigInteger untuk harga kendaraan yang besar
            $table->string('image')->nullable(); // Menyimpan nama file gambar
            $table->enum('status', ['Tersedia', 'Terjual'])->default('Tersedia'); // Status ketersediaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
