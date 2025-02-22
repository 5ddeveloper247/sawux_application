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
        Schema::table('api_settings', function (Blueprint $table) {
            $table->integer('api_refresh_time')->nullable()->after('api_key');
            $table->string('image')->nullable()->after('api_refresh_time');
            $table->tinyInteger('system_status')->nullable()->default('0')->after('image')->comment('0:OFF, 1:ON');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('api_settings', function (Blueprint $table) {
            //
        });
    }
};
