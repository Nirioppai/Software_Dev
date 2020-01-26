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

            $table->bigIncrements('id', 20);
            $table->string('student_id', 10);
            $table->string('name', 40);
            $table->tinyInteger('overall_total_score');
            $table->tinyInteger('verbal_number_correct');
            $table->tinyInteger('non_verbal_number_correct');
            $table->string('birthday', 11);
            $table->string('level', 10);
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
