<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawToScaledNonverbalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement("
        create view `raw_to_scaled_nonverbal` as
        (select * from raw_score_to_scaled_scores where Type = 'Non-Verbal')
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("drop view raw_to_scaled_nonverbal");
    }
}
