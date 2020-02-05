<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalStudentDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_student_datas', function (Blueprint $table) {
          $table->bigIncrements('id', 20);
          $table->string('student_id', 10);
          $table->string('name', 40);
          $table->tinyInteger('overall_total_score');
          $table->tinyInteger('verbal_number_correct');
          $table->tinyInteger('non_verbal_number_correct');
          $table->date('date_of_birth', 11);
          $table->bigInteger('rounded_current_age_in_years');
          $table->bigInteger('rounded_current_age_in_months');
          $table->bigInteger('current_age_in_days');
          $table->string('grade_level', 10);
          $table->date('exam_date');
          $table->integer('batch');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_student_datas');
    }
}
