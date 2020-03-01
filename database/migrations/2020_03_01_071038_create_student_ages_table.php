<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create view `student_age` as
        (SELECT
          	id,
          	student_id,
          	birthday,		
          	IF(rounded_current_age_in_months = 12, current_age_in_years + 1, current_age_in_years + 0) as rounded_current_age_in_years,
          	IF(rounded_current_age_in_months = 12, rounded_current_age_in_months = 0, rounded_current_age_in_months + 0) as rounded_current_age_in_months,
          	current_age_in_days,
          	exam_date,
          	batch,
          	created_at,
          	updated_at
          FROM
          (
          	SELECT
          	id,
          	student_id,
          	student_name,
          	grade,
          	section,
          	birthday,
            current_age_in_years,
          	IF(current_age_in_days > 15, current_age_in_months + 1, current_age_in_months + 0) as rounded_current_age_in_months,
          	current_age_in_days,
          	exam_date,
          	verbal_comprehension,
          	verbal_reasoning,
          	verbal_total_score,
          	quantitative_reasoning,
          	figural_reasoning,
          	non_verbal_total_score,
          	total_score,
          	batch,
          	created_at,
          	updated_at
          FROM
          (
          	SELECT
          	id,
          	student_id,
          	student_name,
          	grade,
          	section,
          	birthday,
            FLOOR(DATEDIFF(exam_date,birthday)/365.30) current_age_in_years,
          	FLOOR((DATEDIFF(exam_date,birthday)/365.30 - FLOOR(DATEDIFF(exam_date,birthday)/365))* 12) current_age_in_months,
          	CEILING((((DATEDIFF(exam_date,birthday)/365.30 - FLOOR(DATEDIFF(exam_date,birthday)/365))* 12) - FLOOR((DATEDIFF(exam_date,birthday)/365.30 - FLOOR(DATEDIFF(exam_date,birthday)/365))* 12))* 30) current_age_in_days,
          	exam_date,
          	verbal_comprehension,
          	verbal_reasoning,
          	verbal_total_score,
          	quantitative_reasoning,
          	figural_reasoning,
          	non_verbal_total_score,
          	total_score,
          	batch,
          	created_at,
          	updated_at
          FROM
          (
          	SELECT
          	id,
          	student_id,
          	student_name,
          	grade,
          	section,
          	birthday,
            exam_date,
          	verbal_comprehension,
          	verbal_reasoning,
          	verbal_total_score,
          	quantitative_reasoning,
          	figural_reasoning,
          	non_verbal_total_score,
          	total_score,
          	batch,
          	created_at,
          	updated_at
          FROM
          	final_student_datas
          ) As current_age_exam_date
          ) As current_age_exam_date
          ) As current_age_exam_date)
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_ages');
    }
}
