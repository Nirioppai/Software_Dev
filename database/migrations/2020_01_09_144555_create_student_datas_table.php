<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create view `student_data` as
        (
          SELECT
          	id,
          	student_id,
          	name,
          	overall_total_score,
          	verbal_number_correct,
          	non_verbal_number_correct,
          	date_of_birth,
          	IF(rounded_current_age_in_months = 12, current_age_in_years + 1, current_age_in_years + 0) as rounded_current_age_in_years,
            IF(rounded_current_age_in_months = 12, rounded_current_age_in_months = 0, rounded_current_age_in_months + 0) as rounded_current_age_in_months,
          	current_age_in_days,
          	exam_date,
          	batch,
          	grade_level
          FROM
          	(
          		SELECT
          			id,
          			student_id,
          			name,
          			overall_total_score,
          			verbal_number_correct,
          			non_verbal_number_correct,
          			date_of_birth,
          			current_age_in_years,
          			IF(current_age_in_days > 15, current_age_in_months + 1, current_age_in_months + 0) as rounded_current_age_in_months,
          			current_age_in_days,
          			exam_date,
          			batch,
          			grade_level
          		FROM
          			(
          				SELECT
          					id,
          					student_id,
          					name,
          					overall_total_score,
          					verbal_number_correct,
          					non_verbal_number_correct,
          					date_of_birth,
          					FLOOR(DATEDIFF(exam_date,date_of_birth)/365.30) current_age_in_years,
          					FLOOR((DATEDIFF(exam_date,date_of_birth)/365.30 - FLOOR(DATEDIFF(exam_date,date_of_birth)/365))* 12) current_age_in_months,
          					CEILING((((DATEDIFF(exam_date,date_of_birth)/365.30 - FLOOR(DATEDIFF(exam_date,date_of_birth)/365))* 12) - FLOOR((DATEDIFF(exam_date,date_of_birth)/365.30 - FLOOR(DATEDIFF(exam_date,date_of_birth)/365))* 12))* 30) current_age_in_days,
          					exam_date,
          					batch,
          					grade_level
          				FROM
          					(
          						SELECT
          							id,
          							student_id,
          							name,
          							overall_total_score,
          							verbal_number_correct,
          							non_verbal_number_correct,
          							STR_TO_DATE(birthday, '%c/%e/%Y ') as date_of_birth,
          							exam_date,
          							batch,
          							level as grade_level
          						FROM
          							student_datas
          					) AS current_age_exam_date
          			) AS current_age_exam_date
              ) AS current_age_exam_date
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
        DB::statement("drop view student_data");
    }
}
