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
     $pdf->loadHTML($this->convert_student_results_to_html($batch))->setPaper('legal', 'landscape');
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
    RS : Raw Score &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    SAI : Scholastic Ability Index &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;
    S : Stanine 
    <br>
    SS : Scaled Score &nbsp;&nbsp;&nbsp;&nbsp;
    PR : Percentile Rank &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    CL : Classification &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
<table width="90%" style="border-collapse: collapse; border: 0px;">
<thead>
     <tr>
    <th class="border" width="0.1%" rowspan="4">No.</th>
    <th class="border" width="0.3%" rowspan="4">Name</th>
    <th class="border" width="0.3%" rowspan="4">Birthday</th>
    <th class="border" width="0.3%" rowspan="4">Age</th>
    <th class="border" width="0.3%" colspan="14" bgcolor="#e6e5e5"> Verbal</th>
    <th class="border" width="0.3%" colspan="14" bgcolor="#e6e5e5"> Non Verbal</th>
    <th class="border" width="0.3%" colspan="10" bgcolor="#e6e5e5">Total Score</th>
    <td class="border" width="0.3%" colspan="2" rowspan="3">Normal Curve Equivalent</td>

    
  </tr>
  <tr>
    <td class="border" width="0.3%" colspan="2" rowspan="2">Verbal Comprehension</td>
    <td class="border" width="0.3%" colspan="2" rowspan="2">Verbal Reasoning</td>
    <td class="border" width="0.3%" colspan="10">Total Verbal </td>
    <td class="border" width="0.3%" colspan="2">Figural Reasoning</td>
    <td class="border" width="0.3%" colspan="2">Quantitative Reasoning</td>
    <td class="border" width="0.3%" colspan="10">Total Nonverbal</td>
    <td class="border" width="0.3%" rowspan="3">No. of Items</td>
    <td class="border" width="0.3%" rowspan="3">RS</td>
    <td class="border" width="0.3%" rowspan="3">SS</td>
    <td class="border" width="0.3%" rowspan="2" colspan="3">Grade Norms</td>
    <td class="border" width="0.3%" rowspan="2" colspan="4">Age Norms</td>

    
  </tr>
  <tr>
    <td class="border" width="0.3%" rowspan="2">No. of Items</td>
    <td class="border" width="0.3%" rowspan="2">RS</td>
    <td class="border" width="0.3%" rowspan="2">SS</td>
    <td class="border" width="0.3%" colspan="3">Grade Norms</td>
    <td class="border" width="0.3%" colspan="4">Age Norms</td>
    <td class="border" width="0.3%" rowspan="2">No. of Items</td>
    <td class="border" width="0.3%" rowspan="2">RS</td>
    <td class="border" width="0.3%" rowspan="2">No. of Items</td>
    <td class="border" width="0.3%" rowspan="2">RS</td>
    <td class="border" width="0.3%" rowspan="2">No. of Items</td>
    <td class="border" width="0.3%" rowspan="2">RS</td>
    <td class="border" width="0.3%" rowspan="2">SS</td>
    <td class="border" width="0.3%" colspan="3">Grade Norms</td>
    <td class="border" width="0.3%" colspan="4">Age Norms</td>


  </tr>
  <tr>
    <td class="border" width="0.3%">No. of Items</td>
    <td class="border" width="0.3%">RS</td>
    <td class="border" width="0.3%">No. of Items</td>
    <td class="border" width="0.3%">RS</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">CL</td>
    <td class="border" width="0.3%">SAI</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">CL</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">CL</td>
    <td class="border" width="0.3%">SAI</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">CL</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">CL</td>
    <td class="border" width="0.3%">SAI</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">CL</td>
    <td class="border" width="0.3%">Age</td>
    <td class="border" width="0.3%">Grade</td>
  </tr>
   </thead>
     ';
     $id = 1;  
     foreach($student_results as $student)
     {
      $output .= '
        <tr>
          <td class="border">'.$id.'</td>
          <td class="border" width="2%">'.$student->student_name.'</td>
          <td class="border" width="1.2%">'.$student->birthday.'</td>
          <td class="border">'.$student->age_year.".".$student->age_month.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
          <td class="border">'.$id.'</td>
        </tr>
      ';
      $id++;
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
