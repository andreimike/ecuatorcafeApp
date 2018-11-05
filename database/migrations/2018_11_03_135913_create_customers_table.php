<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('contractor_ean', 100);
            $table->primary('contractor_ean');
            $table->string('nume', 100)->nullable();
            $table->string('localitate', 100)->nullable();
            $table->string('adresa', 100)->nullable();
            $table->string('judet', 100)->nullable();
            $table->string('tara', 100)->nullable();
            $table->string('iln', 100)->nullable();
            $table->string('cui', 100)->nullable();
            $table->string('reg_com', 100)->nullable();
            $table->string('banca', 100)->nullable();
            $table->string('iban', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('pers_contact', 100)->nullable();
            $table->string('telefon', 100)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
