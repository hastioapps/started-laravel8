<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->char('code',4);
            $table->string('name',100);
            $table->text('address');
            $table->string('email')->nullable();
            $table->char('phone',15)->nullable();
            $table->string('manager',100)->nullable();
            $table->char('status',15)->default('Enabled');
            $table->foreignId('company_id');
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
        Schema::dropIfExists('branches');
    }
}
