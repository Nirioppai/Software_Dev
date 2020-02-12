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
        create view student_batch as

select 
student_id,
name,
DATE_FORMAT(date_of_birth, '%M' ' ' '%d' ', ' '%Y') as date_of_birth,
right(grade_level,2) as grade_level,
rounded_current_age_in_years as age_year,
rounded_current_age_in_months as age_month,
total_raw,
total_scaled,
total_sai,
total_percentile,
total_stanine,
verbal_raw,
verbal_scaled,
verbal_sai,
verbal_percentile,
verbal_stanine,
nonverbal_raw,
nonverbal_scaled,
nonverbal_sai,
nonverbal_percentile,
nonverbal_stanine,
batch,
DATE_FORMAT(exam_date, '%M' ' ' '%d' ', ' '%Y') as exam_date
from final_student_results
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
