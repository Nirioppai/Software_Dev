<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class StudentData extends Model
{
    public $fillable = [
      'student_id',
      'student_name',
      'grade',
      'section',
      'birthday',
      'exam_date',
      'verbal_comprehension',
      'verbal_reasoning',
      'verbal_total_score',
      'quantitative_reasoning',
      'figural_reasoning',
      'non_verbal_total_score',
      'total_score'
    ];
}
