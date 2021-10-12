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
            $table->string('id')->primary();
            $table->string('description');
            $table->char('level_tcode',1);
            $table->string('parent');
            $table->string('icon');
            $table->string('url');
            $table->string('tcode_group');
            $table->string('access');
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
