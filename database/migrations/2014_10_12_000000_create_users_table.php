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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('position_id')->nullable();
            $table->string('phone',20)->nullable();
            $table->text('image')->nullable();
            $table->text('file')->nullable();
            $table->longText('text')->nullable();
            $table->date('order_date')->nullable();
            $table->date('leave_date')->nullable();
            $table->boolean('working')->default(false)->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
