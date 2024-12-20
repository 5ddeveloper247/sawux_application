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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('code');
            $table->integer('postal_code'); // Use string for postal codes
            $table->text('description'); // Text for longer descriptions
            $table->string('address');
            $table->enum('status', ['1', '0'])->default('0'); // Ensure default matches enum type
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // Set to null on delete            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
