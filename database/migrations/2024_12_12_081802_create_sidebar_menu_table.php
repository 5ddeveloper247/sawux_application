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
        Schema::create('sidebar_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Menu item name
            $table->string('link')->nullable(); // Link for the menu item
            $table->string('icon')->nullable(); // Icon for the menu item (optional)
            $table->integer('order')->default(0); // Order of the menu item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebar_menu');
    }
};
