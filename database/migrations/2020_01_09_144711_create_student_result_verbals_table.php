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
              olsat.student_data.student_id,
              olsat.student_data.name,
              olsat.student_data.verbal_number_correct As `Verbal Raw Score`,
              olsat.raw_to_scaled_verbal.scaledscore As `Verbal Scaled Score`,
              olsat.scaled_to_sai_verbal.sai As `Verbal SAI`,
              olsat.sai_to_percentile_rank_and_stanines.percentile_rank As `Verbal Percentile Rank`,
              olsat.sai_to_percentile_rank_and_stanines.stanine As `Verbal Stanine`
          From
              olsat.student_data Inner Join
              olsat.scaled_to_sai_verbal On olsat.student_data.rounded_current_age_in_years = olsat.scaled_to_sai_verbal.age
                      And olsat.scaled_to_sai_verbal.month = olsat.student_data.rounded_current_age_in_months Inner Join
              olsat.raw_to_scaled_verbal On olsat.raw_to_scaled_verbal.rawscore = olsat.student_data.verbal_number_correct
                      And olsat.scaled_to_sai_verbal.gradescore = olsat.raw_to_scaled_verbal.scaledscore Inner Join
              olsat.sai_to_percentile_rank_and_stanines On olsat.sai_to_percentile_rank_and_stanines.sai =
                      olsat.scaled_to_sai_verbal.sai)
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
