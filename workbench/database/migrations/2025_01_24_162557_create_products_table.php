<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 6);
            $table->unsignedInteger('total');
            $table->boolean('is_top');
            $table->unsignedInteger('count')->default(0);
            $table->timestamps();

            $table->unique(['name', 'price']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
