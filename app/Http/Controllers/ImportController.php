<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\StudentData;
use App\CsvData;
use App\Http\Requests\CsvImportRequest;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
class ImportController extends Controller
{
  public function getImport()
  {
      return view('csv');
  }
  public function parseImport(CsvImportRequest $request)
  {
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
          $csv_data = array_slice($data, 0, 2);
          $csv_data_file = CsvData::create([
              'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
              'csv_header' => $request->has('header'),
              'csv_data' => json_encode($data)
          ]);
      } else {
          return redirect()->back();
      }
      return view('import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));
  }
  public function processImport(Request $request)
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
          $studentdata->save();
      }
      return view('import_success');
  }



  public function uploadStudent1 () {

    $step = 1;
    $uploader = 'student';
    return view ('csv_student_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadStudent2 () {

    $step = 2;
    $uploader = 'student';
    return view ('csv_student_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadStudent3 () {

    $step = 3;
    $uploader = 'student';
    return view ('csv_student_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadStudent3Submit () {

    return redirect ('/csv');

  }

  public function uploadScaledScore1 () {

    $step = 1;
    $uploader = 'scaled_scores';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadScaledScore2 () {

    $step = 2;
    $uploader = 'scaled_scores';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadScaledScore3 () {

    $step = 3;
    $uploader = 'scaled_scores';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadScaledScore3Submit () {

    return redirect ('/csv/references');

  }

  public function uploadSAI1 () {

    $step = 1;
    $uploader = 'sai';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadSAI2 () {

    $step = 2;
    $uploader = 'sai';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadSAI3 () {

    $step = 3;
    $uploader = 'sai';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadSAI3Submit () {

    return redirect ('/csv/references');

  }


  public function uploadStanine1 () {

    $step = 1;
    $uploader = 'percentile_stanine';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadStanine2 () {

    $step = 2;
    $uploader = 'percentile_stanine';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadStanine3 () {

    $step = 3;
    $uploader = 'percentile_stanine';
    return view ('csv_references_upload')->with('step', $step)->with('uploader', $uploader);

  }


  public function uploadStanine3Submit () {

    return redirect ('/csv/references');

  }
  
}