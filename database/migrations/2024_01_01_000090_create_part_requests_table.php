<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('part_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20);
            $table->string('whatsapp', 20)->nullable();
            $table->string('city');
            $table->string('vehicle_brand')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year', 10)->nullable();
            $table->string('part_name');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'processing', 'quoted', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('part_requests');
    }
};
