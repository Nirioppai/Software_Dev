<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CancelUploadController extends Controller
{
  public function cancelStudent()
  {

    DB::statement("TRUNCATE TABLE student_datas;
    ");

    $step = 1;
    $uploader = 'student_1';
    $success = ('idle');
    return view ('csv_student_upload')->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }

  public function cancelScaledScores()
    {

      DB::statement("TRUNCATE TABLE raw_score_to_scaled_scores;
      ");

      $step = 1.1;
      $uploader = 'scaled_scores_1';
      $success = ('idle');
      return view('csv_references')->with('success', $success)->with('uploader', $uploader)->with('step', $step);

    }

    public function cancelSAI()
    {

      DB::statement("TRUNCATE TABLE scaled_score_to_sais;
      ");

      $step = 2.1;
      $uploader = 'sai_1';
      $success = ('idle');
      return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader);

    }

    public function cancelStanine()
    {

      DB::statement("TRUNCATE TABLE sai_to_percentile_rank_and_stanines;
      ");

      $step = 3.1;
      $uploader = 'stanine_1';
      $success = ('idle');
      return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader);
      
    }

}
