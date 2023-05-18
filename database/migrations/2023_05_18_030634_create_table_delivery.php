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
        Schema::create('delivery', function (Blueprint $table) {
            

            $table->string("DELIVERY_ID",25)->primary();
            $table->string("DELIVERY_ADDRESS",150)->nullable();
            $table->string("EMP_NAME",150)->nullable();
            $table->string("EMP_PHONE",150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
