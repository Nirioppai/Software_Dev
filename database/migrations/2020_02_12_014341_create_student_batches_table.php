<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        Create View student_batch As
        (
          Select
          	student_id,
          	student_name,
            right(grade,2) as grade,
          	grade as grade_short,
            section,
          	DATE_FORMAT(birthday, '%M' ' ' '%d' ', ' '%Y') as birthday,
          	birthday as birthday_short,
          	rounded_current_age_in_years as age_year,
          	rounded_current_age_in_months as age_month,
            DATE_FORMAT(exam_date, '%M' ' ' '%d' ', ' '%Y') as exam_date,
          	total_raw,
          	total_scaled,
          	total_sai,
          	total_percentile,
          	total_stanine,
          	total_classification,
            verbal_comprehension,
          	verbal_reasoning,
          	verbal_raw,
          	verbal_scaled,
          	verbal_sai,
          	verbal_percentile,
          	verbal_stanine,
          	verbal_classification,
            quantitative_reasoning,
          	figural_reasoning,
          	nonverbal_raw,
          	nonverbal_scaled,
          	nonverbal_sai,
          	nonverbal_percentile,
          	nonverbal_stanine,
          	nonverbal_classification,
          	batch
          From
          	final_student_results
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
        Schema::dropIfExists('student_batches');
    }
}
