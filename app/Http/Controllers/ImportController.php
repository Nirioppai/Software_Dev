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

    $warning = false;
    $step = 1;
    $uploader = 'student_1';
    $success = ('idle');
    return view ('csv_student_upload')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning);

  }


  public function uploadStudent2 (CsvImportRequest $request) {

    function checkDateFormat($date){
       $tempDate = explode('/', $date);
       return checkdate($tempDate[0], $tempDate[1], $tempDate[2]);
    }

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

        // Date Format
        $date_checker = true;

        // String Length
        $length_checker = true;

        // Data Type
        $data_type_checker = true;

        // Date Advancement
        $date_adv_checker = true;

        foreach($data as $student){

          $validate_birthday = checkDateFormat($student['birthday']);
          $validate_exam = checkDateFormat($student['exam_date']);

          $validate_bday = strlen($student['birthday']);
          $validate_examdate = strlen($student['exam_date']);
          $validate_id = strlen($student['student_id']);

          // Data type

          $validate_grade = is_numeric($student['grade']);
          $validate_VC = is_numeric($student['verbal_comprehension']);
          $validate_VR = is_numeric($student['verbal_reasoning']);
          $validate_VT = is_numeric($student['verbal_total_score']);
          $validate_QR = is_numeric($student['quantitative_reasoning']);
          $validate_FR = is_numeric($student['figural_reasoning']);
          $validate_NVT = is_numeric($student['non_verbal_total_score']);
          $validate_T = is_numeric($student['total_score']);

          if($validate_birthday == false || $validate_exam == false){
            $date_checker = false;
            $get_id = $student['student_id'];
          }

          if(($validate_grade == false) || ($validate_VC == false) || ($validate_VR == false) || ($validate_VT == false) || ($validate_QR == false) || ($validate_FR == false) || ($validate_NVT == false) || ($validate_T == false)){
            $data_type_checker = false;
            $get_id = $student['student_id'];
          }

          // 0 - month, 1 - day, 2 - year
          $defragBirthday = explode('/', $student['birthday']);
          $defragExamDate = explode('/', $student['exam_date']);

          $createBirthday = "$defragBirthday[2]-$defragBirthday[0]-$defragBirthday[1]";
          $createExamDate = "$defragExamDate[2]-$defragExamDate[0]-$defragExamDate[1]";

          if(!(strtotime($createExamDate) > strtotime($createBirthday))){
            $date_adv_checker = false;
            $get_id = $student['student_id'];
          }

        }

          if(($date_checker == true) && ($length_checker == true) && ($data_type_checker == true) && ($date_adv_checker == true)){
            $csv_data = array_slice($data, 0, 10);
            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
          } else{
            $warning = true;
            $step = 1;
            $uploader = 'student_1';
            $success = ('idle');
            return view('csv_student_upload')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning)->with('get_id', $get_id);
          }
        }

        else {
          return redirect()->back();
    }

    $step = 2;
    $uploader = 'student_2';
    $success = ('idle');

    return view('csv_student_upload', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('step', $step)->with('uploader', $uploader)->with('success', $success);

  }


  public function uploadStudent3 (Request $request) {

    DB::statement("TRUNCATE TABLE student_datas;
    ");

    $final_student = DB::table('final_student_datas');

    if(($final_student->count()) > 0 ) {
      $max_batch = $final_student->max('batch');
      $batch = $max_batch + 1;
    }
    else {
      $batch = 1;
    }

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
            $studentdata->batch = $batch;
            $studentdata->save();
        }

      $step = 3;
      $uploader = 'student_3';
      $success = ('success');

      return view('csv_student_upload')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('batch', $batch);

  }

  public function uploadScaledScore1 () {

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

        $data_type_checker = true;

        foreach($data as $conversion){

          $validate_raw = is_numeric($conversion['rawscore']);
          $validate_scaled = is_numeric($conversion['scaledscore']);

          if (($validate_raw == false) || ($validate_scaled == false)){
            $data_type_checker = false;
            $get_raw = $conversion['rawscore'];
          }
        }


        if ($data_type_checker == true){
          $csv_data = array_slice($data, 0, 10);
          $csv_data_file = CsvData::create([
              'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
              'csv_header' => $request->has('header'),
              'csv_data' => json_encode($data)
          ]);
        } else{
          $warning = true;
          $step = 1.1;
          $uploader = 'scaled_scores_1';
          return view ('csv_references')->with('step', $step)->with('uploader', $uploader)->with('warning', $warning)->with('get_raw', $get_raw);
        }

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
    $warning = false;
    $step = 2.1;
    $uploader = 'sai_1';
    $success = ('idle');
    return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader)->with('warning', $warning);

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

        $data_type_checker = true;

        foreach($data as $conversion){

          $validate_gradescore = is_numeric($conversion['gradescore']);
          $validate_sai = is_numeric($conversion['sai']);
          $validate_age = is_numeric($conversion['age']);
          $validate_month = is_numeric($conversion['month']);

          if (($validate_gradescore == false) || ($validate_sai == false) || ($validate_age == false) || ($validate_month == false)){
            $data_type_checker = false;
            $get_gradescore = $conversion['gradescore'];
          }
        }

        if ($data_type_checker == true){

          $csv_data = array_slice($data, 0, 10);
          $csv_data_file = CsvData::create([
              'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
              'csv_header' => $request->has('header'),
              'csv_data' => json_encode($data)
          ]);
        } else {
          $warning = true;
          $step = 2.1;
          $uploader = 'sai_1';
          $success = ('idle');
          return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader)->with('warning', $warning)->with('get_gradescore', $get_gradescore);
        }
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
    $warning = false;
    $step = 3.1;
    $uploader = 'stanine_1';
    $success = ('idle');
    return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader)->with('warning', $warning);
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

        $data_type_checker = true;

        foreach($data as $conversion){

          $validate_sai = is_numeric($conversion['sai']);
          $validate_percentile_rank = is_numeric($conversion['percentile_rank']);
          $validate_stanine = is_numeric($conversion['stanine']);

          if (($validate_sai == false) || ($validate_percentile_rank == false) || ($validate_stanine == false)){
            $data_type_checker = false;
            $get_sai = $conversion['sai'];
          }
        }

        if ($data_type_checker == true){

          $csv_data = array_slice($data, 0, 10);
          $csv_data_file = CsvData::create([
              'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
              'csv_header' => $request->has('header'),
              'csv_data' => json_encode($data)
          ]);
        } else {
          $warning = true;
          $step = 3.1;
          $uploader = 'stanine_1';
          $success = ('idle');
          return view('csv_references')->with('step', $step)->with('success', $success)->with('uploader', $uploader)->with('warning', $warning)->with('get_sai', $get_sai);
        }

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

            $total_classification = DB::table('student_result_total')->where('id',  $i)->pluck('total_classification')->first();

            $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
            $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
            $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
            $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

            $verbal_comprehension = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_comprehension')->first();
            $verbal_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_reasoning')->first();
            $verbal_classification = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_classification')->first();

            $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
            $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
            $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
            $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

            $quantitative_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('quantitative_reasoning')->first();
            $figural_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('figural_reasoning')->first();
            $nonverbal_classification = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_classification')->first();

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

              $update = FinalStudentResult::where('id', $i)->update(['total_classification' => $total_classification]);

              $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

              $update = FinalStudentResult::where('id', $i)->update(['verbal_comprehension' => $verbal_comprehension]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_reasoning' => $verbal_reasoning]);
              $update = FinalStudentResult::where('id', $i)->update(['verbal_classification' => $verbal_classification]);

              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);

              $update = FinalStudentResult::where('id', $i)->update(['quantitative_reasoning' => $quantitative_reasoning]);
              $update = FinalStudentResult::where('id', $i)->update(['figural_reasoning' => $figural_reasoning]);
              $update = FinalStudentResult::where('id', $i)->update(['nonverbal_classification' => $nonverbal_classification]);


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

    DB::statement("INSERT INTO final_student_datas (student_id, student_name, grade, section, birthday, rounded_current_age_in_years, rounded_current_age_in_months, current_age_in_days, exam_date, verbal_comprehension, verbal_reasoning, verbal_total_score, quantitative_reasoning, figural_reasoning, non_verbal_total_score, total_score, batch, created_at, updated_at)

       SELECT student_id, student_name, grade, section, birthday, rounded_current_age_in_years, rounded_current_age_in_months, current_age_in_days, exam_date, verbal_comprehension, verbal_reasoning, verbal_total_score, quantitative_reasoning, figural_reasoning, non_verbal_total_score, total_score, batch, created_at, updated_at FROM student_data;
    ");

    DB::statement("TRUNCATE TABLE student_datas;
    ");


    //get current batch
    $max_batch = FinalStudentData::max('batch');
    //insert where batch = current batch, to prevent duplicate entries
    DB::statement("INSERT INTO final_student_results (id, student_id, student_name, grade, section, birthday, rounded_current_age_in_years, rounded_current_age_in_months, exam_date, verbal_comprehension, verbal_reasoning, verbal_raw, quantitative_reasoning, figural_reasoning, nonverbal_raw, total_raw, batch, created_at, updated_at)

       SELECT id, student_id, student_name, grade, section, birthday, rounded_current_age_in_years, rounded_current_age_in_months, exam_date, verbal_comprehension, verbal_reasoning, verbal_total_score, quantitative_reasoning, figural_reasoning, non_verbal_total_score, total_score, batch, created_at, updated_at  FROM final_student_datas WHERE batch = ".$max_batch.";
    ");

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

          $total_classification = DB::table('student_result_total')->where('id',  $i)->pluck('total_classification')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $verbal_comprehension = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_comprehension')->first();
          $verbal_reasoning = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_reasoning')->first();
          $verbal_classification = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_classification')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          $quantitative_reasoning = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('quantitative_reasoning')->first();
          $figural_reasoning = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('figural_reasoning')->first();
          $nonverbal_classification = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_classification')->first();

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

            $update = FinalStudentResult::where('id', $i)->update(['total_classification' => $total_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_comprehension' => $verbal_comprehension]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_reasoning' => $verbal_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_classification' => $verbal_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['quantitative_reasoning' => $quantitative_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['figural_reasoning' => $figural_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_classification' => $nonverbal_classification]);

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
    $warning = false;
    $step = 1;
    $uploader = 'scaled_1';
    $success = ('idle');

    return view('csv_scaled')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning);
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

        $data_type_checker = true;

        foreach($data as $conversion){

          $validate_raw = is_numeric($conversion['rawscore']);
          $validate_scaled = is_numeric($conversion['scaledscore']);

          if (($validate_raw == false) || ($validate_scaled == false)){
            $data_type_checker = false;
            $get_raw = $conversion['rawscore'];
          }
        }


        if ($data_type_checker == true){

          $csv_data = array_slice($data, 0, 10);
          $csv_data_file = CsvData::create([
              'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
              'csv_header' => $request->has('header'),
              'csv_data' => json_encode($data)
          ]);
        } else {
          $warning = true;
          $step = 1;
          $uploader = 'scaled_1';
          $success = ('idle');
          return view('csv_scaled')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning)->with('get_raw', $get_raw);
        }


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

          $total_classification = DB::table('student_result_total')->where('id',  $i)->pluck('total_classification')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $verbal_comprehension = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_comprehension')->first();
          $verbal_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_reasoning')->first();
          $verbal_classification = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_classification')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          $quantitative_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('quantitative_reasoning')->first();
          $figural_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('figural_reasoning')->first();
          $nonverbal_classification = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_classification')->first();

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

            $update = FinalStudentResult::where('id', $i)->update(['total_classification' => $total_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_comprehension' => $verbal_comprehension]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_reasoning' => $verbal_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_classification' => $verbal_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['quantitative_reasoning' => $quantitative_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['figural_reasoning' => $figural_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_classification' => $nonverbal_classification]);

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
    $warning = false;
    $step = 1;
    $uploader = 'sai_1';
    $success = ('idle');

    return view('csv_sai')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning);
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

        $data_type_checker = true;

        foreach($data as $conversion){

          $validate_gradescore = is_numeric($conversion['gradescore']);
          $validate_sai = is_numeric($conversion['sai']);
          $validate_age = is_numeric($conversion['age']);
          $validate_month = is_numeric($conversion['month']);

          if (($validate_gradescore == false) || ($validate_sai == false) || ($validate_age == false) || ($validate_month == false)){
            $data_type_checker = false;
            $get_gradescore = $conversion['gradescore'];
          }
        }

        if ($data_type_checker == true){
          $csv_data = array_slice($data, 0, 10);
          $csv_data_file = CsvData::create([
              'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
              'csv_header' => $request->has('header'),
              'csv_data' => json_encode($data)
          ]);
        } else{
          $warning = true;
          $step = 1;
          $uploader = 'sai_1';
          $success = ('idle');
          return view('csv_sai')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning)->with('get_gradescore', $get_gradescore);
        }


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

          $total_classification = DB::table('student_result_total')->where('id',  $i)->pluck('total_classification')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $verbal_comprehension = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_comprehension')->first();
          $verbal_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_reasoning')->first();
          $verbal_classification = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_classification')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          $quantitative_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('quantitative_reasoning')->first();
          $figural_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('figural_reasoning')->first();
          $nonverbal_classification = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_classification')->first();

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

            $update = FinalStudentResult::where('id', $i)->update(['total_classification' => $total_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_comprehension' => $verbal_comprehension]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_reasoning' => $verbal_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_classification' => $verbal_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['quantitative_reasoning' => $quantitative_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['figural_reasoning' => $figural_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_classification' => $nonverbal_classification]);


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
    $warning = false;
    $step = 1;
    $uploader = 'stanine_1';
    $success = ('idle');

    return view('csv_stanine')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning);
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

        $data_type_checker = true;

        foreach($data as $conversion){

          $validate_sai = is_numeric($conversion['sai']);
          $validate_percentile_rank = is_numeric($conversion['percentile_rank']);
          $validate_stanine = is_numeric($conversion['stanine']);

          if (($validate_sai == false) || ($validate_percentile_rank == false) || ($validate_stanine == false)){
            $data_type_checker = false;
            $get_sai = $conversion['sai'];
          }
        }

        if ($data_type_checker == true){
          $csv_data = array_slice($data, 0, 10);
          $csv_data_file = CsvData::create([
              'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
              'csv_header' => $request->has('header'),
              'csv_data' => json_encode($data)
          ]);
        } else{
          $warning = true;
          $step = 1;
          $uploader = 'stanine_1';
          $success = ('idle');
          return view('csv_stanine')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning)->with('get_sai', $get_sai);
        }

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

          $total_classification = DB::table('student_result_total')->where('id',  $i)->pluck('total_classification')->first();

          $verbal_scaled = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_scaled_score')->first();
          $verbal_sai = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_sai')->first();
          $verbal_percentile = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_percentile_rank')->first();
          $verbal_stanine = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_stanine')->first();

          $verbal_comprehension = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_comprehension')->first();
          $verbal_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('verbal_reasoning')->first();
          $verbal_classification = DB::table('student_result_verbal')->where('id',  $i)->pluck('verbal_classification')->first();

          $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_scaled_score')->first();
          $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_sai')->first();
          $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_percentile_rank')->first();
          $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_stanine')->first();

          $quantitative_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('quantitative_reasoning')->first();
          $figural_reasoning = DB::table('final_student_datas')->where('id',  $i)->pluck('figural_reasoning')->first();
          $nonverbal_classification = DB::table('student_result_nonverbal')->where('id',  $i)->pluck('nonverbal_classification')->first();

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

            $update = FinalStudentResult::where('id', $i)->update(['total_classification' => $total_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_scaled' => $verbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_percentile' => $verbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_sai' => $verbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_stanine' => $verbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['verbal_comprehension' => $verbal_comprehension]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_reasoning' => $verbal_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['verbal_classification' => $verbal_classification]);

            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_scaled' => $nonverbal_scaled]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_percentile' => $nonverbal_percentile]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_sai' => $nonverbal_sai]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_stanine' => $nonverbal_stanine]);

            $update = FinalStudentResult::where('id', $i)->update(['quantitative_reasoning' => $quantitative_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['figural_reasoning' => $figural_reasoning]);
            $update = FinalStudentResult::where('id', $i)->update(['nonverbal_classification' => $nonverbal_classification]);


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
    $warning = false;
    $step = 1;
    $uploader = 'scaled_1';
    $success = ('idle');
    DB::statement("TRUNCATE TABLE raw_score_to_scaled_scores;");

    return view('csv_scaled')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning);
  }


  public function selectiveSAIRestart() {
    $warning = false;
    $step = 1;
    $uploader = 'sai_1';
    $success = ('idle');
    DB::statement("TRUNCATE TABLE scaled_score_to_sais;");

    return view('csv_sai')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning);
  }


  public function selectiveStanineRestart() {
    $warning = false;
    $step = 1;
    $uploader = 'stanine_1';
    $success = ('idle');
    DB::statement("TRUNCATE TABLE sai_to_percentile_rank_and_stanines;");

    return view('csv_stanine')->with('step', $step)->with('uploader', $uploader)->with('success', $success)->with('warning', $warning);
  }


}
