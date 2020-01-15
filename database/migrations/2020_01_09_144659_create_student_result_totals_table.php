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
              olsat.student_data.overall_total_score As `total_raw_score`,
              olsat.raw_to_scaled_total.scaledscore As `total_scaled_score`,
              olsat.scaled_to_sai_total.sai As `total_sai`,
              olsat.sai_to_percentile_rank_and_stanines.percentile_rank As `total_percentile_rank`,
              olsat.sai_to_percentile_rank_and_stanines.stanine As `total_stanine`
          From
              olsat.student_data Inner Join
              olsat.scaled_to_sai_total On olsat.scaled_to_sai_total.age = olsat.student_data.rounded_current_age_in_years
                      And olsat.scaled_to_sai_total.month = olsat.student_data.rounded_current_age_in_months Inner Join
              olsat.raw_to_scaled_total On olsat.raw_to_scaled_total.rawscore = olsat.student_data.overall_total_score
                      And olsat.scaled_to_sai_total.gradescore = olsat.raw_to_scaled_total.scaledscore Inner Join
              olsat.sai_to_percentile_rank_and_stanines On olsat.sai_to_percentile_rank_and_stanines.sai =
                      olsat.scaled_to_sai_total.sai)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("drop view student_result_total");
    }
}
