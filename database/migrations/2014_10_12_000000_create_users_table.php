<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('username',10);
            $table->string('name',100);
            $table->string('email')->unique();
            $table->char('phone',15)->nullable();
            $table->string('password');
            $table->char('role_id',10)->nullable();
            $table->char('status',15)->default('Enabled');
            $table->char('started',10);
            $table->string('img')->nullable();
            $table->boolean('master');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreignId('company_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
