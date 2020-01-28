<?php

namespace App\Http\Controllers;
use App\StudentData;
use App\FinalStudentData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CopyFromInitialToFinal extends Controller
{
    function copyWithBatchTruncate()
    {
        $initial_student = DB::table('student_data')->orderBy('id', 'asc');

        foreach($initial_student  as $row)
        {
          $final_student = new FinalStudentData;

          $final_student->student_id = $row->student_id;
          $final_student->name = $row->name;
          $final_student->overall_total_score = $row->overall_total_score;
          $final_student->verbal_number_correct = $row->verbal_number_correct;
          $final_student->non_verbal_number_correct = $row->non_verbal_number_correct;
          $final_student->birthday = $row->birthday;
          $final_student->level = $row->level;
          $final_student->exam_date = $row->exam_date;

          $final_student->save();
        }
    }

}
