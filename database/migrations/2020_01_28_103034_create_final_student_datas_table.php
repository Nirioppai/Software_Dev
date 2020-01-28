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
          $table->string('student_id', 10)->nullable();
          $table->string('name', 40)->nullable();
          $table->tinyInteger('overall_total_score')->nullable();
          $table->tinyInteger('verbal_number_correct')->nullable();
          $table->tinyInteger('non_verbal_number_correct')->nullable();
          $table->string('birthday', 11)->nullable();
          $table->string('level', 10)->nullable();
          $table->string('exam_date', 11)->nullable();
          $table->integer('batch')->nullable();
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
