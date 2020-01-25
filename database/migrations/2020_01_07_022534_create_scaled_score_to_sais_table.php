<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScaledScoreToSaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scaled_score_to_sais', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('gradescore');
            $table->mediumInteger('sai');
            $table->tinyInteger('age');
            $table->tinyInteger('month');
            $table->string('type', 11);
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
        Schema::dropIfExists('scaled_score_to_sais');
    }
}
