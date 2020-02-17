<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalStudentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_student_results', function (Blueprint $table) {
              $table->increments('id');
              $table->string('student_id', 10);
              $table->string('student_name', 40);
              $table->string('grade', 10);
              $table->string('section', 10);
              $table->date('date_of_birth', 11);
              $table->bigInteger('rounded_current_age_in_years')->default(0);
              $table->bigInteger('rounded_current_age_in_months')->default(0);
              $table->date('exam_date');
              $table->mediumInteger('total_raw')->default(0);
              $table->mediumInteger('total_scaled')->default(0);
              $table->mediumInteger('total_sai')->default(0);
              $table->mediumInteger('total_percentile')->default(0);
              $table->mediumInteger('total_stanine')->default(0);
              $table->mediumInteger('verbal_raw')->default(0);
              $table->mediumInteger('verbal_scaled')->default(0);
              $table->mediumInteger('verbal_sai')->default(0);
              $table->mediumInteger('verbal_percentile')->default(0);
              $table->mediumInteger('verbal_stanine')->default(0);
              $table->mediumInteger('nonverbal_raw')->default(0);
              $table->mediumInteger('nonverbal_scaled')->default(0);
              $table->mediumInteger('nonverbal_sai')->default(0);
              $table->mediumInteger('nonverbal_percentile')->default(0);
              $table->mediumInteger('nonverbal_stanine')->default(0);
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
        Schema::dropIfExists('final_student_results');
    }
}
