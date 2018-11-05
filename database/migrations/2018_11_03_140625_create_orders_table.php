<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_number');
            $table->string('contractor_ean_id', 100);
            $table->foreign('contractor_ean_id')->references('contractor_ean')->on('customers')->onDelete('cascade');
            $table->text('product');
            $table->integer('serial_number')->default(0)->nullable();
            $table->string('notice_pdf_path', 100)->nullable();
            $table->boolean('notice')->default(false)->nullable();
            $table->boolean('conformity_declaration')->default(false)->nullable();
            $table->boolean('dpd_shipping')->default(false)->nullable();
            $table->boolean('smart_bill_invoice')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.conformity_declaration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

