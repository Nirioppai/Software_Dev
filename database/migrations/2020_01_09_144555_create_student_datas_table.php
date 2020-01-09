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
          (SELECT
          id,
          student_id,
          name,
          overall_total_score,
          verbal_number_correct,
          non_verbal_number_correct,
          date_of_birth,
          IF(rounded_current_age_in_months = 12, current_age_in_years + 1 && rounded_current_age_in_months = 0, current_age_in_years + 0) as rounded_current_age_in_years,
          IF(current_age_in_days>15, current_age_in_months + 1, current_age_in_months + 0) as rounded_current_age_in_months,
          current_age_in_days,
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
          current_age_in_months,
          current_age_in_days,
          IF(current_age_in_days>15, current_age_in_months + 1, current_age_in_months + 0) as rounded_current_age_in_months,
          grade_level
          FROM
          (
            SELECT
          id
          , student_id
          , name
          , overall_total_score
          , verbal_number_correct
          , non_verbal_number_correct
          , date_of_birth
          , FLOOR(DATEDIFF(CURDATE(),date_of_birth)/365.30) current_age_in_years
          , FLOOR((DATEDIFF(CURDATE(),date_of_birth)/365.30 - FLOOR(DATEDIFF(CURDATE(),date_of_birth)/365))* 12) current_age_in_months
          , CEILING((((DATEDIFF(CURDATE(),date_of_birth)/365.30 - FLOOR(DATEDIFF(CURDATE(),date_of_birth)/365))* 12)
          - FLOOR((DATEDIFF(CURDATE(),date_of_birth)/365.30 - FLOOR(DATEDIFF(CURDATE(),date_of_birth)/365))* 12))* 30) current_age_in_days
          , grade_level
          FROM
          (
            select
          id,
          student_id,
          name,
          overall_total_score,
          verbal_number_correct,
          non_verbal_number_correct,
          STR_TO_DATE(birthday, '%c/%e/%Y ') as date_of_birth,
          level as grade_level from student_datas
          ) AS current_age_current_date
          ) AS current_age_current_date
          ) AS current_age_current_date)
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
