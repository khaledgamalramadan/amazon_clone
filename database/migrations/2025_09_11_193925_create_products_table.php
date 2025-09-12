<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand');  // مثل "Mintra"
            $table->string('title');  // مثل "Unisex School Backpack 3 Pocket Large"
            $table->text('description')->nullable();  // وصف إضافي، اختياري
            $table->decimal('price', 8, 2);  // السعر الحالي، مثل 1380.00
            $table->decimal('old_price', 8, 2)->nullable();  // السعر القديم، مثل 2299.99
            $table->integer('rating')->default(4);  // عدد النجوم، افتراضي 4
            $table->integer('reviews_count')->default(2);  // عدد التقييمات، افتراضي 2
            $table->date('delivery_date');  // تاريخ التوصيل، مثل "2025-09-13"
            $table->string('image');  // مسار الصورة، مثل "assets/product_page.jpg"
            $table->timestamps();  // created_at و updated_at تلقائي
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