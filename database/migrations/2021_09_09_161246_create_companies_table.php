<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->text('address');
            $table->string('currency_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('npwp')->nullable();
            $table->string('npwp_name')->nullable();
            $table->text('npwp_address')->nullable();
            $table->string('img')->nullable();
            $table->string('owner');
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
        Schema::dropIfExists('companies');
    }
}
