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
<table width="96%" style="border-collapse: collapse; border: 0px;">
<thead>
     <tr>
    <th class="border" width="0.1%" rowspan="4">No.</th>
    <th class="border" width="0.3%" rowspan="4">Name</th>
    <th class="border" width="0.3%" rowspan="4">DOB</th>
    <th class="border" width="0.3%" rowspan="4">Age</th>
    <th class="border" width="0.3%" colspan="14"> Verbal</th>
    <th class="border" width="0.3%" colspan="14"> Non Verbal</th>
    <th class="border" width="0.3%" colspan="10">Total Score</th>
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
    <td class="border" width="0.3%">Classification</td>
    <td class="border" width="0.3%">SAI</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">Classification</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">Classification</td>
    <td class="border" width="0.3%">SAI</td>
    <td class="border" width="0.3%">PR</td>
    <td class="border" width="0.3%">S</td>
    <td class="border" width="0.3%">Classification</td>
    <td class="border" width="0.3%">Age</td>
    <td class="border" width="0.3%">Grade</td>
  </tr>
   </thead>
     ';  
     foreach($student_results as $student)
     {
      $output .= '
        <tr>
          <td class="border">1</td>
          <td class="border">2</td>
          <td class="border">3</td>
          <td class="border">4</td>
          <td class="border">5</td>
          <td class="border">6</td>
          <td class="border">7</td>
          <td class="border">8</td>
          <td class="border">9</td>
          <td class="border">10</td>
          <td class="border">11</td>
          <td class="border">12</td>
          <td class="border">13</td>
          <td class="border">14</td>
          <td class="border">15</td>
          <td class="border">16</td>
          <td class="border">17</td>
          <td class="border">18</td>
          <td class="border">19</td>
          <td class="border">20</td>
          <td class="border">21</td>
          <td class="border">22</td>
          <td class="border">23</td>
          <td class="border">24</td>
          <td class="border">25</td>
          <td class="border">26</td>
          <td class="border">27</td>
          <td class="border">28</td>
          <td class="border">29</td>
          <td class="border">30</td>
          <td class="border">31</td>
          <td class="border">32</td>
          <td class="border">33</td>
          <td class="border">34</td>
          <td class="border">35</td>
          <td class="border">36</td>
          <td class="border">37</td>
          <td class="border">38</td>
          <td class="border">39</td>
          <td class="border">40</td>
          <td class="border">41</td>
          <td class="border">42</td>
          <td class="border">43</td>
          <td class="border">44</td>
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
