<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BatchedStudentData extends Model
{
  protected $table = 'batched_student_datas'; 
  protected $fillable = [
  'student_id',
  'name',
  'overall_total_score',
  'verbal_number_correct',
  'non_verbal_number_correct',
  'birthday',
  'level',
  'exam_date',
  'batch'
  ];
}
