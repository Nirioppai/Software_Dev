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
                (
                  Select
                      olsat.final_student_datas.student_id,
                      olsat.final_student_datas.name,
                      olsat.final_student_datas.non_verbal_number_correct As nonverbal_raw_score,
                      olsat.raw_to_scaled_nonverbal.scaledscore As nonverbal_scaled_score,
                      olsat.scaled_to_sai_nonverbal.sai As nonverbal_sai,
                      olsat.sai_to_percentile_rank_and_stanines.percentile_rank As nonverbal_percentile_rank,
                      olsat.sai_to_percentile_rank_and_stanines.stanine As nonverbal_stanine
                  From
                      olsat.final_student_datas Inner Join
                      olsat.raw_to_scaled_nonverbal On
                              olsat.raw_to_scaled_nonverbal.rawscore = olsat.final_student_datas.non_verbal_number_correct Inner Join
                      olsat.scaled_to_sai_nonverbal On olsat.scaled_to_sai_nonverbal.gradescore =
                              olsat.raw_to_scaled_nonverbal.scaledscore
                              And olsat.scaled_to_sai_nonverbal.age = olsat.final_student_datas.rounded_current_age_in_years
                              And olsat.scaled_to_sai_nonverbal.month = olsat.final_student_datas.rounded_current_age_in_months Inner Join
                      olsat.sai_to_percentile_rank_and_stanines On olsat.sai_to_percentile_rank_and_stanines.sai =
                              olsat.scaled_to_sai_nonverbal.sai
                )
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
