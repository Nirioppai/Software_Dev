<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScaledToSaiNonverbalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement("
        create view `scaled_to_sai_nonverbal` as
        (select * from scaled_score_to_sais where Type = 'Non-Verbal')
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      DB::statement("drop view scaled_to_sai_nonverbal");
    }
}
