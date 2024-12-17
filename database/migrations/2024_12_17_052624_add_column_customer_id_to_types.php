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
        Schema::table('types', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('customer_id')->nullable()->after('status');

            // Define the foreign key
            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('SET NULL'); // Option to set NULL when the customer is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('types', function (Blueprint $table) {
            //
            $table->dropForeign(['customer_id']);

            // Drop the column
            $table->dropColumn('customer_id');
        });
    }
};
