<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class StudentData extends Model
{
    public $fillable = [
      'student_id', 'name', 'overall_total_score', 'verbal_number_correct',
      'non_verbal_number_correct', 'birthday', 'level'
    ];
}