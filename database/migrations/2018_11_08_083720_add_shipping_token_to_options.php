<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShippingTokenToOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options', function ($table) {
            $table->string('shipping_api_token', 100)->nullable()->after('serial_number');
            $table->dateTime('validity_shipping_api_token')->nullable()->after('shipping_api_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options', function ($table) {
            $table->dropColumn('shipping_api_token');
            $table->dropColumn('validity_shipping_api_token');
        });
    }
}
