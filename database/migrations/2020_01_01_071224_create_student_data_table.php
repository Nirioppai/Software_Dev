<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id');
            $table->string('name');
            $table->integer('overall_total_score');
            $table->integer('verbal_number_correct');
            $table->integer('non_verbal_number_correct');
            $table->string('birthday');
            $table->string('level');
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
        Schema::dropIfExists('student_data');
    }
}
