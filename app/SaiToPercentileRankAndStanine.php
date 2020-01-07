<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaiToPercentileRankAndStanine extends Model
{
  public $fillable = [
    'sai',
    'percentile_rank',
    'stanine',
    'type'
  ];
}
