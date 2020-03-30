<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttestatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attestats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fio');
            $table->bigInteger('user_id')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->bigInteger('limit');
            $table->bigInteger('time');
            $table->string('status')->default('progress');
            $table->text('question_ids');
            $table->text('answer')->nullable();
            $table->text('true_answers')->nullable();
            $table->text('wrong_answers')->nullable();
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
        Schema::dropIfExists('attestats');
    }
}
