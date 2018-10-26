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
            $table->string('contractor_ean_id');
            $table->foreign('contractor_ean_id')->references('contractor_ean')->on('customers')->onDelete('cascade');
            $table->text('product');
            $table->integer('notice_number')->nullable();
            $table->boolean('notice')->default(false);
            $table->boolean('conformity_declaration')->default(false);
            $table->boolean('dpd_shipping')->default(false);
            $table->boolean('smart_bill_invoice')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
