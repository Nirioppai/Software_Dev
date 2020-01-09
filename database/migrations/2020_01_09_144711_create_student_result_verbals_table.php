<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentResultVerbalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
          create view `student_result_verbal` as
          (Select
              olsat.student_data.id,
              olsat.student_data.student_id As `Student ID`,
              olsat.student_data.name As Name,
              olsat.student_data.verbal_number_correct As `Verball Raw Score`,
              olsat.raw_to_scaled_verbal.scaledscore As `Verbal Scaled Score`,
              olsat.scaled_to_sai_verbal.sai As `Verbal SAI`,
              olsat.sai_to_percentile_rank_and_stanines.percentile_rank As `Verbal Percentile Rank`,
              olsat.sai_to_percentile_rank_and_stanines.stanine As `Verbal Stanine`
          From
              olsat.student_data Inner Join
              olsat.raw_to_scaled_verbal On olsat.student_data.verbal_number_correct = olsat.raw_to_scaled_verbal.rawscore
              Inner Join
              olsat.scaled_to_sai_verbal On olsat.raw_to_scaled_verbal.scaledscore = olsat.scaled_to_sai_verbal.gradescore
                      And olsat.student_data.rounded_current_age_in_years = olsat.scaled_to_sai_verbal.age
                      And olsat.student_data.rounded_current_age_in_months = olsat.scaled_to_sai_verbal.month Inner Join
              olsat.sai_to_percentile_rank_and_stanines On
                      olsat.scaled_to_sai_verbal.sai = olsat.sai_to_percentile_rank_and_stanines.sai)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("drop view student_result_verbal");
    }
}
