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
     return $pdf->stream();
     //return $pdf->download('Student Results Batch '.$batch. '.pdf');
    }

    function convert_student_results_to_html($batch)
    {
     $student_results = $this->exportBatch($batch);
     $date_of_testing = DB::table('student_batch')->where('batch',  $batch)->pluck('exam_date')->first();
     $output = '
     <!DOCTYPE html>
<html>
<head>
    <link href="./css/pdf.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body class="body">
<img style="width: 100%; height: 100%;" src="./img/pdf/PDF_header.png">

        
<footer>
    Legend:
    <br>
    1 : Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    2 : Verbal &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    3 : Nonverbal 
    <br>
    R : Raw Score &nbsp;&nbsp;&nbsp;&nbsp;
    S : Scaled Score &nbsp;&nbsp;&nbsp;&nbsp;
    SA : SAI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    P : Percentile &nbsp;&nbsp;&nbsp;&nbsp;
    ST : Stanine &nbsp;&nbsp;&nbsp;&nbsp;
</footer>
     
<main class ="main">

<div>

    <p class="enlarged" style ="padding-left: 4%;">Student Result Batch: '.$batch.' 
        <br>
        Date of Testing: '.$date_of_testing. '
        <br>
        School: Xavier School San Juan
<br>
<br>
     <h3 align="center">BATCH SUMMARY REPORT</h3>
     <br>
<table width="100%" style="border-collapse: collapse; border: 0px;">
<thead>
    <tr>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.2%">Student No.</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.3%">Name</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.23%">DOB</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">Grade</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">Age</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">1R</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">1S</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">1SA</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">1P</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">1ST</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">2R</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">2S</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">2SA</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">2P</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">2ST</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">3R</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">3S</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">3SA</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">3P</th>
    <th bgcolor="#e6e5e5" style="border: 1px solid; padding:1px; text-align:center;" width="0.1%">3ST</th>
   </tr>
   </thead>
     ';  
     foreach($student_results as $student)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->student_id.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->name.'</td>
       <td style="border: 1px solid; padding:2px; text-align:center;">'.$student->date_of_birth_short.'</td>
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

</div>

</main>
</body>
</html>
';
     return $output;
    }


}
