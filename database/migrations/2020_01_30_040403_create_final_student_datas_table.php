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
          $table->string('student_name', 60);
          $table->string('grade', 10);
          $table->string('section', 10);
          $table->date('birthday', 11);
          $table->bigInteger('rounded_current_age_in_years');
          $table->bigInteger('rounded_current_age_in_months');
          $table->bigInteger('current_age_in_days');
          $table->date('exam_date');
          $table->tinyInteger('verbal_comprehension');
          $table->tinyInteger('verbal_reasoning');
          $table->tinyInteger('verbal_total_score');
          $table->tinyInteger('quantitative_reasoning');
          $table->tinyInteger('figural_reasoning');
          $table->tinyInteger('non_verbal_total_score');
          $table->tinyInteger('total_score');
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
