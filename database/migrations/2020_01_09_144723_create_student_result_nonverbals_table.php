<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
 
class CreateStudentResultNonverbalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create view `student_result_nonverbal` as
        (Select
              olsat.student_data.id,
              olsat.student_data.student_id,
              olsat.student_data.name,
              olsat.student_data.non_verbal_number_correct As `non_verbal_raw_score`,
              olsat.raw_to_scaled_nonverbal.scaledscore As `non_verbal_scaled_score`,
              olsat.scaled_to_sai_nonverbal.sai As `non_verbal_sai`,
              olsat.sai_to_percentile_rank_and_stanines.percentile_rank As `non_verbal_percentile_rank`,
              olsat.sai_to_percentile_rank_and_stanines.stanine As `non_verbal_stanine`
          From
              olsat.student_data Inner Join
              olsat.raw_to_scaled_nonverbal On olsat.student_data.non_verbal_number_correct =
                      olsat.raw_to_scaled_nonverbal.rawscore Inner Join
              olsat.scaled_to_sai_nonverbal On olsat.raw_to_scaled_nonverbal.scaledscore =
                      olsat.scaled_to_sai_nonverbal.gradescore
                      And olsat.student_data.rounded_current_age_in_years = olsat.scaled_to_sai_nonverbal.age
                      And olsat.scaled_to_sai_nonverbal.month = olsat.student_data.rounded_current_age_in_months Inner Join
              olsat.sai_to_percentile_rank_and_stanines On olsat.scaled_to_sai_nonverbal.sai =
                      olsat.sai_to_percentile_rank_and_stanines.sai)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("drop view student_result_nonverbal");
    }
}
