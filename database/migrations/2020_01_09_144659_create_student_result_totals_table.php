<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentResultTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
          create view `student_result_total` as
          (Select
          olsat.student_data.id,
          olsat.student_data.student_id,
          olsat.student_data.name,
          olsat.student_data.overall_total_score As `Total Raw Score`,
          olsat.raw_to_scaled_total.scaledscore As `Total Scaled SCore`,
          olsat.scaled_to_sai_total.sai As `Total SAI`,
          olsat.sai_to_percentile_rank_and_stanines.percentile_rank As `Total Percentile Rank`,
          olsat.sai_to_percentile_rank_and_stanines.stanine As `Total Stanine`
          From
          olsat.student_data Inner Join
          olsat.raw_to_scaled_total On olsat.student_data.overall_total_score = olsat.raw_to_scaled_total.rawscore Inner Join
          olsat.scaled_to_sai_total On olsat.raw_to_scaled_total.scaledscore = olsat.scaled_to_sai_total.gradescore
                  And olsat.scaled_to_sai_total.age = olsat.student_data.rounded_current_age_in_years
                  And olsat.scaled_to_sai_total.month = olsat.student_data.rounded_current_age_in_months Inner Join
          olsat.sai_to_percentile_rank_and_stanines On
                  olsat.scaled_to_sai_total.sai = olsat.sai_to_percentile_rank_and_stanines.sai)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SDB::statement("drop view student_result_total");
    }
}
