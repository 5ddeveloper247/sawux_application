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
        Schema::create('dynamic_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->nullable();
            $table->integer('sub_type_id')->nullable();
            $table->string('pre_title')->nullable();
            $table->string('post_title')->nullable();
            $table->string('parameter')->nullable();
            $table->integer('parameter_id')->nullable();
            $table->tinyInteger('on_off_flag')->nullable()->default('0')->comment('0:OFF, 1:ON');
            $table->tinyInteger('status')->nullable()->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_parameters');
    }
};
