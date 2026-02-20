<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ceilings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('price');
            $table->decimal('thickness', 5, 2);
            $table->unsignedInteger('width');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('manufacturer_id')->constrained('manufacturers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ceilings');
    }
};
