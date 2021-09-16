<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcodes', function (Blueprint $table) {
            $table->char('id',4)->primary();
            $table->string('description',200);
            $table->char('level_tcode',1);
            $table->char('parent',4);
            $table->string('icon',50);
            $table->string('url',500);
            $table->char('tcode_group_id',4);
            $table->char('access',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcodes');
    }
}
