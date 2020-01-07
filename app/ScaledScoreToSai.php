<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScaledScoreToSai extends Model
{
  public $fillable = [
    'gradescore',
    'sai',
    'age',
    'month',
    'type'
  ];
}
