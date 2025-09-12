<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('company', 150)->nullable();
            $table->string('street', 200);
            $table->string('apartment', 100)->nullable();
            $table->string('city', 100);
            $table->string('phone', 20);
            $table->string('email');
            $table->enum('payment', ['cash', 'card']);
            $table->string('coupon', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
