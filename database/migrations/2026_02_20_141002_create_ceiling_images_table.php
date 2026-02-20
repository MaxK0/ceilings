<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ceiling_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->integer('sort')->default(0);
            $table->foreignId('ceiling_id')->constrained('ceilings')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ceiling_images');
    }
};
