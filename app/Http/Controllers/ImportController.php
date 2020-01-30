<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\StudentData;
use App\FinalStudentData;
use App\CsvData;
use App\RawScoreToScaledScore;
use App\ScaledScoreToSai;
use App\SaiToPercentileRankAndStanine;
use App\Http\Requests\CsvImportRequest;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class ImportController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

  // public function getImport()
  // {
  //     return view('csv');
  // }
  // public function parseImport(CsvImportRequest $request)
  // {
  //     $path = $request->file('csv_file')->getRealPath();
  //     if ($request->has('header')) {
  //         $data = Excel::load($path, function($reader) {})->get()->toArray();
  //     } else {
  //         $data = array_map('str_getcsv', file($path));
  //     }
  //     if (count($data) > 0) {
  //         if ($request->has('header')) {
  //             $csv_header_fields = [];
  //             foreach ($data[0] as $key => $value) {
  //                 $csv_header_fields[] = $key;
  //             }
  //         }
  //         $csv_data = array_slice($data, 0, 2);
  //         $csv_data_file = CsvData::create([
  //             'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
  //             'csv_header' => $request->has('header'),
  //             'csv_data' => json_encode($data)
  //         ]);
  //     } else {
  //         return redirect()->back();
  //     }
  //     return view('import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));
  // }
  // public function processImport(Request $request)
  // {
  //     $data = CsvData::find($request->csv_data_file_id);
  //     $csv_data = json_decode($data->csv_data, true);
  //     foreach ($csv_data as $row) {
  //         $studentdata = new StudentData();
  //         foreach (config('app.db_fields') as $index => $field) {
  //             if ($data->csv_header) {
  //                 $studentdata->$field = $row[$request->fields[$field]];
  //             } else {
  //                 $studentdata->$field = $row[$request->fields[$index]];
  //             }
  //         }
  //         $studentdata->save();
  //     }
  //     return view('import_success');
  // }



  public function uploadStudent1 () {

    $step = 1;
    $uploader = 'student_1';
    $success = ('idle');
    return view ('csv_student_upload')->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }


  public function uploadStudent2 (CsvImportRequest $request) {

    $date_today = date("Y-m-d");

    $path = $request->file('csv_file')->getRealPath();
    if ($request->has('header')) {
        $data = Excel::load($path, function($reader) {})->get()->toArray();
    } else {
        $data = array_map('str_getcsv', file($path));
    }
    if (count($data) > 0) {
        if ($request->has('header')) {
            $csv_header_fields = [];
            foreach ($data[0] as $key => $value) {
                $csv_header_fields[] = $key;
            }
        }
        $csv_data = array_slice($data, 0, 5);
        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }

    $step = 2;
    $uploader = 'student_2';
    $success = ('idle');

    return view('csv_student_upload', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('date_today', $date_today);

  }


  public function uploadStudent3 (Request $request) {

    $date_of_exam = $request->date_of_exam;

    $final_student = DB::table('final_student_datas');

    if(($final_student->count()) > 0 ) {
      $max_batch = $final_student->max('batch');
      $batch = $max_batch + 1;
    }
    else {
      $batch = 1;
    }

    function checkExamDate($date)
    {
      $tempDate = explode('-', $date);
      return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }

    $validate_exam_date = checkExamDate($date_of_exam);

      if(($validate_exam_date == TRUE))
      {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);

        foreach ($csv_data as $row) {
            $studentdata = new StudentData();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {
                    $studentdata->$field = $row[$request->fields[$field]];
                } else {
                    $studentdata->$field = $row[$request->fields[$index]];
                }
            }
            $studentdata->exam_date = $date_of_exam;
            $studentdata->batch = $batch;
            $studentdata->save();

        }

      // $add_batch = DB::table('final_student_datas');
      //
      // if(($add_batch->count()) > 0 ) {
      //   $batch = 2;
      // }
      // else {
      //   $batch = 1;
      // }
      //
      // $initial_student = DB::table('student_datas');
      //
      // foreach($initial_student as $row){
      //
      //   $insert_batch = new StudentData;
      //   $insert_batch->batch = $batch;
      //   $insert_batch->save();
      //
      // }

      $step = 3;
      $uploader = 'student_3';
      $success = ('success');

      return view('csv_student_upload')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
    }
  }


  // public function uploadStudent3Submit () {
  //
  //   return redirect ('/csv');
  //
  // }

  public function uploadScaledScore1 () {

    $step = 1;
    $uploader = 'scaled_scores';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadScaledScore2 (CsvImportRequest $request) {

    $path = $request->file('csv_file')->getRealPath();
    if ($request->has('header')) {
        $data = Excel::load($path, function($reader) {})->get()->toArray();
    } else {
        $data = array_map('str_getcsv', file($path));
    }
    if (count($data) > 0) {
        if ($request->has('header')) {
            $csv_header_fields = [];
            foreach ($data[0] as $key => $value) {
                $csv_header_fields[] = $key;
            }
        }
        $csv_data = array_slice($data, 0, 5);
        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }

    $step = 1.2;
    $uploader = 'scaled_scores_2';
    $success = ('idle');

    return view('csv_references', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }


  public function uploadScaledScore3 (Request $request) {

    $data = CsvData::find($request->csv_data_file_id);
    $csv_data = json_decode($data->csv_data, true);

    foreach ($csv_data as $row) {
        $rawtoscaledscore = new RawScoreToScaledScore();
        foreach (config('app.db_raw_to_scaleds') as $index => $field) {
            if ($data->csv_header) {
                $rawtoscaledscore->$field = $row[$request->fields[$field]];
            } else {
                $rawtoscaledscore->$field = $row[$request->fields[$index]];
            }
        }
        $rawtoscaledscore->save();
    }


    $step = 1.3;
    $success = ('idle');
    $uploader = 'scaled_scores_3';

    return view('csv_references')->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }

  public function uploadSAI1 () {

    $step = 2.1;
    $uploader = 'sai_1';
    $success = ('idle');
    return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader);

  }


  public function uploadSAI2 (CsvImportRequest $request) {

    $path = $request->file('csv_file')->getRealPath();
    if ($request->has('header')) {
        $data = Excel::load($path, function($reader) {})->get()->toArray();
    } else {
        $data = array_map('str_getcsv', file($path));
    }
    if (count($data) > 0) {
        if ($request->has('header')) {
            $csv_header_fields = [];
            foreach ($data[0] as $key => $value) {
                $csv_header_fields[] = $key;
            }
        }
        $csv_data = array_slice($data, 0, 5);
        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }

    $success = ('idle');
    $step = 2.2;
    $uploader = 'sai_2';
    return view('csv_references', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }


  public function uploadSAI3 (Request $request) {

    $data = CsvData::find($request->csv_data_file_id);
    $csv_data = json_decode($data->csv_data, true);

    foreach ($csv_data as $row) {
        $scaledtosai = new ScaledScoreToSai();
        foreach (config('app.db_scaled_to_sais') as $index => $field) {
            if ($data->csv_header) {
                $scaledtosai->$field = $row[$request->fields[$field]];
            } else {
                $scaledtosai->$field = $row[$request->fields[$index]];
            }
        }
        $scaledtosai->save();
    }

    $success = ('idle');
    $step = 2.3;
    $uploader = 'sai_3';

    return view('csv_references')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  // public function uploadSAI3Submit () {
  //
  //   return redirect ('/csv/references');
  //
  // }

  public function uploadStanine1 () {

    $step = 3.1;
    $uploader = 'stanine_1';
    $success = ('idle');
    return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader);
  }


  public function uploadStanine2 (CsvImportRequest $request) {

    $path = $request->file('csv_file')->getRealPath();
    if ($request->has('header')) {
        $data = Excel::load($path, function($reader) {})->get()->toArray();
    } else {
        $data = array_map('str_getcsv', file($path));
    }
    if (count($data) > 0) {
        if ($request->has('header')) {
            $csv_header_fields = [];
            foreach ($data[0] as $key => $value) {
                $csv_header_fields[] = $key;
            }
        }
        $csv_data = array_slice($data, 0, 5);
        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }

    $success = ('idle');
    $step = 3.2;
    $uploader = 'stanine_2';
    return view('csv_references', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }


  public function uploadStanine3 (Request $request) {

    $data = CsvData::find($request->csv_data_file_id);
    $csv_data = json_decode($data->csv_data, true);

    foreach ($csv_data as $row) {
        $saitopercentile = new SaiToPercentileRankAndStanine();
        foreach (config('app.db_sai_to_percentile_ranks') as $index => $field) {
            if ($data->csv_header) {
                $saitopercentile->$field = $row[$request->fields[$field]];
            } else {
                $saitopercentile->$field = $row[$request->fields[$index]];
            }
        }
        $saitopercentile->save();
    }

    $success = ('idle');
    $step = 3.3;
    $uploader = 'stanine_3';
    return view('csv_references')->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }

  public function finalizeUpload()
  {
    // DITO ILILIPAT LAMAN NG VIEW SA final_STUDENT_DATAS

    DB::statement("INSERT INTO final_student_datas (student_id, name, overall_total_score, verbal_number_correct, non_verbal_number_correct, date_of_birth, rounded_current_age_in_years, rounded_current_age_in_months, current_age_in_days, grade_level)

       SELECT student_id, name, overall_total_score, verbal_number_correct, non_verbal_number_correct, date_of_birth, rounded_current_age_in_years, rounded_current_age_in_months, current_age_in_days, grade_level FROM student_data;
    ");

    DB::statement("TRUNCATE TABLE student_datas;
    ");

    $success = ('success');
    return redirect('/csv')->with('success', $success);
  }

}
