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
            $table->string("DELIVERY_ID",20)->primary();
            $table->string("DELIVERY_ADDRESS",150)->nullable();
            $table->string("EMP_NAME",50)->nullable();
            $table->string("EMP_PHONE",15)->nullable();
            $table->string("EMP_EMAIL",50)->nullable();
            $table->string("EMP_DELIVERY_DATE",150)->nullable();
            $table->string("EMP_DELIVERY_TIME",150)->nullable();
            $table->string("EMP_DELIVERY_INSTRUCTION",150)->nullable();
            $table->string("EMP_SHIPPING_METHOD",50)->nullable();
            $table->string("EMP_SHIPPING_CARRIER",50)->nullable();
            $table->string("EMP_TRACKING_NUMBER",50)->nullable();
            $table->string("EMP_PACKAGE_WEIGHT",50)->nullable();
            $table->string("EMP_PACKAGE_DIMENSION",50)->nullable();
            $table->string("EMP_DELIVERY_CONFIRMATION",50)->nullable();
            $table->string("EMP_SIGNATURE_REQUIRED",50)->nullable();
            $table->string("EMP_ORDER_NUMBER",50)->nullable();
            $table->string("EMP_SHIPPING_COST",50)->nullable();
            $table->string("EMP_INSURANCE",50)->nullable();
            $table->string("EMP_CUSTOMS_INFO",50)->nullable();
            $table->string("EMP_ORDER_STATUS",50)->nullable();
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
