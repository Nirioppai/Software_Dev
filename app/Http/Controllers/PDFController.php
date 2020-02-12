<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use DB;

class PDFController extends Controller
{
    public function viewPDF(Request $request)
    {

        $student_number = $request->student_no;

        $student_details = DB::table('student_batch')->where('student_id',  $request->student_no)->first();

        $pdf = PDF::loadView('student_result_export', array('student_details' => $student_details));

        return $pdf->stream();
    }

    public function savePDF(Request $request)
    {

        $student_number = $request->student_no;

        $student_details = DB::table('student_batch')->where('student_id',  $request->student_no)->first();

        $pdf = PDF::loadView('student_result_export', array('student_details' => $student_details));
        return $pdf->download('Student Result '.$student_number. '.pdf');
    }


    function viewBatch($batch)
    {
     $batch_results = DB::table('final_student_results')->where('batch',  $batch)->get();

     $pdf = PDF::loadView('student_result_batch_export', array('batch_results' => $batch_results));
     return $pdf->stream();
    }

    function exportBatch($batch)
    {
     $student_results = DB::table('student_batch')->where('batch',  $batch)->get();
     return $student_results;
    }

    function pdf($batch)
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_student_results_to_html($batch));
     return $pdf->download('Student Results Batch '.$batch. '.pdf');
    }

    function convert_student_results_to_html($batch)
    {
     $student_results = $this->exportBatch($batch);
     $output = '
     <!DOCTYPE html>
<html>
<head>
    <link href="./css/pdf.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body class="body">

     <h3 align="center">student Data</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.4%">Student Number</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.3%">Name</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.5%">Date of Birth</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">Grade</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">Age</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">TR</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">TS</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">TSA</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">TP</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">TST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">VST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">VST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">VST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">VST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">VST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">NVST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">NVST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">NVST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">NVST</th>
    <th style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">NVST</th>
   </tr>
     ';  
     foreach($student_results as $student)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->student_id.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->name.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->date_of_birth.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->grade_level.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->age_year.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->total_raw.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->total_scaled.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->total_sai.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->total_percentile.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->total_stanine.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->verbal_raw.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->verbal_scaled.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->verbal_sai.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->verbal_percentile.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->verbal_stanine.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->nonverbal_raw.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->nonverbal_scaled.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->nonverbal_sai.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->nonverbal_percentile.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->nonverbal_stanine.'</td>
      </tr>
      ';
     }
     $output .= '</table>



     </body>
</html>
';
     return $output;
    }


}
