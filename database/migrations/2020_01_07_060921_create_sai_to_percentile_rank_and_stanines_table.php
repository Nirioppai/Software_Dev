<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaiToPercentileRankAndStaninesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sai_to_percentile_rank_and_stanines', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('sai');
            $table->mediumInteger('percentile_rank');
            $table->mediumInteger('stanine');
            $table->string('type', 20);
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
        Schema::dropIfExists('sai_to_percentile_rank_and_stanines');
    }
}
