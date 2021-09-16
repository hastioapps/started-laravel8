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
            $table->id();
            $table->string('name',100);
            $table->text('address');
            $table->char('currency_id',4);
            $table->string('email')->nullable();
            $table->char('phone',15)->nullable();
            $table->char('npwp',20)->nullable();
            $table->string('npwp_name',100)->nullable();
            $table->text('npwp_address')->nullable();
            $table->char('img',20)->nullable();
            $table->string('owner',100);
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
