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
        Schema::create('glbmbizpartner', function (Blueprint $table) {
            $table->unsignedInteger('DELIVERY_ID');
           $table->string('DELIVERY_ADDRESS',10)->nullable();
            $table->string('EMP_NAME',20)->nullable();
            $table->string('EMP_PHONE',30)->nullable();
            $table->string('EMP_EMAIL',50)->nullable();
            $table->string('EMP_DELIVERY_DATE',30)->nullable();
            $table->string('EMP_DELIVERY_TIME',1)->nullable();
            $table->string('EMP_DELIVERY_INSTRUCTION',10)->nullable();
            $table->string('EMP_SHIPPING_METHOD',10)->nullable();
            $table->string('EMP_SHIPPING_CARRIER',10)->nullable();
            $table->string('EMP_TRACKING_NUMBER',10)->nullable();
            $table->string('EMP_PACKAGE_WEIGHT',10)->nullable();
            $table->string('EMP_PACKAGE_DIMENSION',10)->nullable();
            $table->string('EMP_DELIVERY_CONFIRMATION',10)->nullable();
            $table->string('EMP_SIGNATURE_REQUIRED',10)->nullable();
            $table->string('EMP_ORDER_NUMBER',10)->nullable();
            $table->string('EMP_SHIPPING_COST',10)->nullable();
            $table->string('EMP_INSURANCE',10)->nullable();
            $table->string('EMP_CUSTOMS_INFO',10)->nullable();
            $table->string('EMP_ORDER_STATUS',10)->nullable();

            $table->string('created_by',45);
            $table->string('updated_by',45);
            $table->timestamps();
            $table->primary(array('DELIVERY_ID'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};