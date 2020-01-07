<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RawScoreToScaledScore extends Model
{
  public $fillable = [
    'rawscore',
    'scaledscore',
    'type'
  ];
}
