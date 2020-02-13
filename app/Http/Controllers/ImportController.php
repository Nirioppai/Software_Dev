<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\StudentData;
use App\FinalStudentData;
use App\CsvData;
use App\RawScoreToScaledScore;
use App\ScaledScoreToSai;
use App\SaiToPercentileRankAndStanine;
use App\FinalStudentResult;
use App\StudentRemark;
use App\student_result_total;
use App\student_result_verbal;
use App\student_result_nonverbal;
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
        $csv_data = array_slice($data, 0, 10);
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

    DB::statement("TRUNCATE TABLE student_datas;
    ");

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



      $step = 3;
      $uploader = 'student_3';
      $success = ('success');

      return view('csv_student_upload')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('batch', $batch);
    }
  }

  public function uploadScaledScore1 () {

        //dito ako tumigil
        $scaledCount = RawScoreToScaledScore::all();
        $stanineCount = RawScoreToScaledScore::all();
        $saiCount = ScaledScoreToSai::all();
        if(!count($scaledCount) && !count($stanineCount) && !count($saiCount))
        {
          $step = 1;
          $uploader = 'scaled_scores';
          return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);
        }


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
        $csv_data = array_slice($data, 0, 10);
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
        $csv_data = array_slice($data, 0, 10);
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
        $csv_data = array_slice($data, 0, 10);
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


    $final_student = DB::table('final_student_datas');

    if(($final_student->count()) > 0 ) {

      $max_id = DB::table('final_student_datas')->max('id');

      for($i = 1; $i <= $max_id; $i++ )
          {
            //taga kuha ng total raw sa current ID
            // $total_raw = DB::table('student_result_total')->where('id',  $i)->pluck('total_raw_score')->first();
            $total_scaled = DB::table('student_result_total')->where('id',  $i)->pluck('total_scaled_score')->first();
            $total_sai = DB::table('student_result_total')->where('id',  $i)->pluck('total_sai')->first();
            $total_percentile = DB::table('student_result_total')->where('id',  $i)->pluck('total_percentile_rank')->first();
            $total_stanine = DB::table('student_result_total')->where('id',  $i)->pluck('total_stanine')->first();

            $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
            $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
            $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
            $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

            $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
            $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
            $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
            $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

            // optimal magpasok dito ng function to check if $total_raw is null
            // if null, plus 1 then check ulet, if not, proceed sa baba


            $totalID = DB::table('student_result_total')->where('id',  $i)->exists();
            $verbalID = DB::table('student_result_verbal')->where('id',  $i)->exists();
            $nonverbalID = DB::table('student_result_nonverbal')->where('id',  $i)->exists();

            if ($totalID == true && $verbalID == true && $nonverbalID == true)
            {

              // $update = FinalStudentResult::where('id', $i)->update(['total_raw' => $total_raw]);
              $update = FinalStudentResult::where('id', $i)->update(['total_scaled' => $total_scaled]);
              $update = FinalStudentResult::where('id', $i)->update(['total_sai' => $total_sai]);
              $update = FinalStudentResult::where('id', $i)->update(['total_percentile' => $total_percentile]);
              $update = FinalStudentResult::where('id', $i)->update(['total_stanine' => $total_stanine]);

              $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);


            }
            else
            {
                continue;
            }

          }

    }

    $success = ('idle');
    $step = 3.3;
    $uploader = 'stanine_3';
    return view('csv_references')->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }


  public function finalizeUpload() {
    // DITO ILILIPAT LAMAN NG VIEW SA final_STUDENT_DATAS

    DB::statement("INSERT INTO final_student_datas (student_id, name, overall_total_score, verbal_number_correct, non_verbal_number_correct, date_of_birth, rounded_current_age_in_years, rounded_current_age_in_months, current_age_in_days, grade_level, exam_date, batch, created_at, updated_at)

       SELECT student_id, name, overall_total_score, verbal_number_correct, non_verbal_number_correct, date_of_birth, rounded_current_age_in_years, rounded_current_age_in_months, current_age_in_days, grade_level, exam_date, batch, created_at, updated_at FROM student_data;
    ");

    DB::statement("TRUNCATE TABLE student_datas;
    ");


    //get current batch
    $max_batch = FinalStudentData::max('batch');
    //insert where batch = current batch, to prevent duplicate entries
    DB::statement("INSERT INTO final_student_results (id, student_id, name, total_raw, verbal_raw, nonverbal_raw, date_of_birth, rounded_current_age_in_years, rounded_current_age_in_months, grade_level, exam_date, batch, created_at)

       SELECT id, student_id, name, overall_total_score, verbal_number_correct, non_verbal_number_correct, date_of_birth, rounded_current_age_in_years, rounded_current_age_in_months, grade_level, exam_date, batch, created_at  FROM final_student_datas WHERE batch = ".$max_batch.";
    ");

    $count_new_batch = DB::table('final_student_datas')->where('batch',  $max_batch)->count();
    //
    // for($j = 1; $j <= $count_new_batch; $j++ ){
    //    $studentremarks = new StudentRemark();
    //    $studentremarks->remarks = '';
    //    $studentremarks->save();
    // }

    //  * WORKS FINE ABOVE THIS LINE

    // * WELCOME TO FUCK UP LAND, kinomment ko lang pu yung for loop to give u a fresh start


    //medyo hindi pa stable, havent tested it that efficiently
    $max_id = FinalStudentData::where('batch', $max_batch)->max('id');

    //for loop to loop through every ID in student result total, and write it to final student result table

    for($i = 1; $i <= $max_id; $i++ )
        {
          //taga kuha ng total raw sa current ID
          // $total_raw = DB::table('student_result_total')->where('id',  $i)->pluck('total_raw_score')->first();
          $total_scaled = DB::table('student_result_total')->where('id',  $i)->pluck('total_scaled_score')->first();
          $total_sai = DB::table('student_result_total')->where('id',  $i)->pluck('total_sai')->first();
          $total_percentile = DB::table('student_result_total')->where('id',  $i)->pluck('total_percentile_rank')->first();
          $total_stanine = DB::table('student_result_total')->where('id',  $i)->pluck('total_stanine')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          // optimal magpasok dito ng function to check if $total_raw is null
          // if null, plus 1 then check ulet, if not, proceed sa baba


          $totalID = DB::table('student_result_total')->where('id',  $i)->exists();
          $verbalID = DB::table('student_result_verbal')->where('id',  $i)->exists();
          $nonverbalID = DB::table('student_result_nonverbal')->where('id',  $i)->exists();

          if ($totalID == true && $verbalID == true && $nonverbalID == true)
          {

            // $update = FinalStudentResult::where('id', $i)->update(['total_raw' => $total_raw]);
            $update = FinalStudentResult::where('id', $i)->update(['total_scaled' => $total_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['total_sai' => $total_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['total_percentile' => $total_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['total_stanine' => $total_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);


          }
          else
          {
              continue;
          }

        }


    $success = ('success');
    return redirect('/students')->with('success', $success);
  }


  public function selectiveScaledAdd() {
    $step = 1;
    $uploader = 'scaled_1';
    $success = ('idle');

    return view('csv_scaled')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveScaledAdd2(CsvImportRequest $request) {

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
        $csv_data = array_slice($data, 0, 10);
        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }

    $step = 2;
    $uploader = 'scaled_2';
    $success = ('idle');

    return view('csv_scaled', compact('csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveScaledAdd3(Request $request) {

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

    $max_id = DB::table('final_student_datas')->max('id');

    for($i = 1; $i <= $max_id; $i++ )
        {
          //taga kuha ng total raw sa current ID
          // $total_raw = DB::table('student_result_total')->where('id',  $i)->pluck('total_raw_score')->first();
          $total_scaled = DB::table('student_result_total')->where('id',  $i)->pluck('total_scaled_score')->first();
          $total_sai = DB::table('student_result_total')->where('id',  $i)->pluck('total_sai')->first();
          $total_percentile = DB::table('student_result_total')->where('id',  $i)->pluck('total_percentile_rank')->first();
          $total_stanine = DB::table('student_result_total')->where('id',  $i)->pluck('total_stanine')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          // optimal magpasok dito ng function to check if $total_raw is null
          // if null, plus 1 then check ulet, if not, proceed sa baba


          $totalID = DB::table('student_result_total')->where('id',  $i)->exists();
          $verbalID = DB::table('student_result_verbal')->where('id',  $i)->exists();
          $nonverbalID = DB::table('student_result_nonverbal')->where('id',  $i)->exists();

          if ($totalID == true && $verbalID == true && $nonverbalID == true)
          {

            // $update = FinalStudentResult::where('id', $i)->update(['total_raw' => $total_raw]);
            $update = FinalStudentResult::where('id', $i)->update(['total_scaled' => $total_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['total_sai' => $total_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['total_percentile' => $total_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['total_stanine' => $total_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);


          }
          else
          {
              continue;
          }

        }

    $step = 3;
    $uploader = 'scaled_3';
    $success = ('idle');

    return view('csv_scaled')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveSAIAdd() {
    $step = 1;
    $uploader = 'sai_1';
    $success = ('idle');

    return view('csv_sai')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveSAIAdd2(CsvImportRequest $request) {

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
        $csv_data = array_slice($data, 0, 10);
        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }

    $step = 2;
    $uploader = 'sai_2';
    $success = ('idle');

    return view('csv_sai', compact('csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveSAIAdd3(Request $request) {

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


    $max_id = DB::table('final_student_datas')->max('id');

    for($i = 1; $i <= $max_id; $i++ )
        {
          //taga kuha ng total raw sa current ID
          // $total_raw = DB::table('student_result_total')->where('id',  $i)->pluck('total_raw_score')->first();
          $total_scaled = DB::table('student_result_total')->where('id',  $i)->pluck('total_scaled_score')->first();
          $total_sai = DB::table('student_result_total')->where('id',  $i)->pluck('total_sai')->first();
          $total_percentile = DB::table('student_result_total')->where('id',  $i)->pluck('total_percentile_rank')->first();
          $total_stanine = DB::table('student_result_total')->where('id',  $i)->pluck('total_stanine')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          // optimal magpasok dito ng function to check if $total_raw is null
          // if null, plus 1 then check ulet, if not, proceed sa baba


          $totalID = DB::table('student_result_total')->where('id',  $i)->exists();
          $verbalID = DB::table('student_result_verbal')->where('id',  $i)->exists();
          $nonverbalID = DB::table('student_result_nonverbal')->where('id',  $i)->exists();

          if ($totalID == true && $verbalID == true && $nonverbalID == true)
          {

            // $update = FinalStudentResult::where('id', $i)->update(['total_raw' => $total_raw]);
            $update = FinalStudentResult::where('id', $i)->update(['total_scaled' => $total_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['total_sai' => $total_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['total_percentile' => $total_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['total_stanine' => $total_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);


          }
          else
          {
              continue;
          }

        }

    $step = 3;
    $uploader = 'sai_3';
    $success = ('idle');

    return view('csv_sai')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveStanineAdd() {
    $step = 1;
    $uploader = 'stanine_1';
    $success = ('idle');

    return view('csv_stanine')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveStanineAdd2(CsvImportRequest $request) {

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
        $csv_data = array_slice($data, 0, 10);
        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }

    $step = 2;
    $uploader = 'stanine_2';
    $success = ('idle');

    return view('csv_stanine', compact('csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveStanineAdd3(Request $request) {

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


    $max_id = DB::table('final_student_datas')->max('id');

    for($i = 1; $i <= $max_id; $i++ )
        {
          //taga kuha ng total raw sa current ID
          // $total_raw = DB::table('student_result_total')->where('id',  $i)->pluck('total_raw_score')->first();
          $total_scaled = DB::table('student_result_total')->where('id',  $i)->pluck('total_scaled_score')->first();
          $total_sai = DB::table('student_result_total')->where('id',  $i)->pluck('total_sai')->first();
          $total_percentile = DB::table('student_result_total')->where('id',  $i)->pluck('total_percentile_rank')->first();
          $total_stanine = DB::table('student_result_total')->where('id',  $i)->pluck('total_stanine')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          // optimal magpasok dito ng function to check if $total_raw is null
          // if null, plus 1 then check ulet, if not, proceed sa baba


          $totalID = DB::table('student_result_total')->where('id',  $i)->exists();
          $verbalID = DB::table('student_result_verbal')->where('id',  $i)->exists();
          $nonverbalID = DB::table('student_result_nonverbal')->where('id',  $i)->exists();

          if ($totalID == true && $verbalID == true && $nonverbalID == true)
          {

            // $update = FinalStudentResult::where('id', $i)->update(['total_raw' => $total_raw]);
            $update = FinalStudentResult::where('id', $i)->update(['total_scaled' => $total_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['total_sai' => $total_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['total_percentile' => $total_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['total_stanine' => $total_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);


          }
          else
          {
              continue;
          }

        }

    $step = 3;
    $uploader = 'stanine_3';
    $success = ('idle');

    return view('csv_stanine')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveScaledRestart() {

    $step = 1;
    $uploader = 'scaled_1';
    $success = ('idle');
    DB::statement("TRUNCATE TABLE raw_score_to_scaled_scores;");

    return view('csv_scaled')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveSAIRestart() {

    $step = 1;
    $uploader = 'sai_1';
    $success = ('idle');
    DB::statement("TRUNCATE TABLE scaled_score_to_sais;");

    return view('csv_sai')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


  public function selectiveStanineRestart() {

    $step = 1;
    $uploader = 'stanine_1';
    $success = ('idle');
    DB::statement("TRUNCATE TABLE sai_to_percentile_rank_and_stanines;");

    return view('csv_stanine')->with('step', $step)->with('uploader', $uploader)->with('success', $success);
  }


}
