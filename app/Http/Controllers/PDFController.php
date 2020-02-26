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
                
                <h1 align="center">OTIS-LENNON SCHOOL ABILITY TEST 8th Ed. Level F</h1>
                <h2 align="center">Masterlist Report</h2>
                <p class="enlarged">
                School: Xavier School San Juan
            
                <br>
                Date of Testing: '.$date_of_testing. '
                <br>
                Student Result Batch: '.$batch.' 
                <br>
        <table width="90%" style="border-collapse: collapse; border: 0px;">
            <thead>
                <tr>
  	<th class="normal-border" width="0.3%" rowspan="4">No.</th>
  	<th class="normal-border" width="0.3%" rowspan="4">Name</th>
  	<th class="normal-border" width="0.3%" rowspan="4">Birthday</th>
  	<th class="normal-border" width="0.3%" rowspan="4">Age</th>
    <th class="normal-border" width="0.3%" colspan="8">Verbal</th>
    <th class="normal-border" width="0.3%" colspan="8">Non Verbal</th>
    <th class="normal-border" width="0.3%" colspan="6">Total Score</th>
    <th class="normal-border" width="0.3%" colspan="2" rowspan="2">Normal Curve Equivalent</th>
    

    
  </tr>
  <tr>
    <td class="normal-border" width="0.3%">Verbal Comprehension</td>
    <td class="normal-border" width="0.3%" >Verbal Reasoning</td>
    <td class="normal-border" width="0.3%" colspan="6">Total Verbal</td>
    <td class="normal-border" width="0.3%">Figural Reasoning</td>
    <td class="normal-border" width="0.3%">Quantitative Reasoning</td>
    <td class="normal-border" width="0.3%" colspan="6">Total Non Verbal</td>
    <td class="normal-border" width="0.3%" rowspan="3">RS</td>
    <td class="normal-border" width="0.3%" rowspan="3">SS</td>
    <td class="normal-border" width="0.3%" rowspan="2" colspan="4">Age Norms</td>

    
  </tr>
  <tr>
    <td class="normal-border" width="0.3%" rowspan="2">RS</td>
    <td class="normal-border" width="0.3%" rowspan="2">RS</td>
    <td class="normal-border" width="0.3%" rowspan="2">RS</td>
    <td class="normal-border" width="0.3%" rowspan="2">SS</td>
    <td class="normal-border" width="0.3%" colspan="4">Age Norms</td>
    <td class="normal-border" width="0.3%" rowspan="2">RS</td>
    <td class="normal-border" width="0.3%" rowspan="2">RS</td>
    <td class="normal-border" width="0.3%" rowspan="2">RS</td>
    <td class="normal-border" width="0.3%" rowspan="2">SS</td>
    <td class="normal-border" width="0.3%" colspan="4">Age Norms</td>
    <td class="normal-border" width="0.3%" rowspan="2">Age</td>
    <td class="normal-border" width="0.3%" rowspan="2">Grade</td>


  </tr>
  <tr>
  	<td class="normal-border" width="0.3%">SAI</td>
  	<td class="normal-border" width="0.3%">PR</td>
    <td class="normal-border" width="0.3%">S</td>
    <td class="normal-border" width="0.3%">CL</td>
    <td class="normal-border" width="0.3%">SAI</td>
    <td class="normal-border" width="0.3%">PR</td>
    <td class="normal-border" width="0.3%">S</td>
    <td class="normal-border" width="0.3%">CL</td>
    <td class="normal-border" width="0.3%">SAI</td>
    <td class="normal-border" width="0.3%">PR</td>
    <td class="normal-border" width="0.3%">S</td>
    <td class="normal-border" width="0.3%">CL</td>
    
  </tr>

            </thead>
            ';
            $i = 1;  
            foreach($student_results as $student)
            {
            $output .= '
            <tr>
                <td class="normal-border">'.$i.'</td>
                <td class="normal-border" width="0.7%">'.$student->student_name.'</td>
                <td class="normal-border" width="0.6%">'.$student->birthday.'</td>
                <td class="normal-border">'.$student->age_year.".".$student->age_month.'</td>
                <td class="normal-border">'.$student->verbal_comprehension.'</td>
                <td class="normal-border">'.$student->verbal_reasoning.'</td>
                <td class="normal-border">'.$student->verbal_raw.'</td>
                <td class="normal-border">'.$student->verbal_scaled.'</td>
                <td class="normal-border">'.$student->verbal_sai.'</td>
                <td class="normal-border">'.$student->verbal_percentile.'</td>
                <td class="normal-border">'.$student->verbal_stanine.'</td>
                <td class="normal-border">'.$student->verbal_classification.'</td>
                <td class="normal-border">'.$student->figural_reasoning.'</td>
                <td class="normal-border">'.$student->quantitative_reasoning.'</td>
                <td class="normal-border">'.$student->nonverbal_raw.'</td>
                <td class="normal-border">'.$student->nonverbal_scaled.'</td>
                <td class="normal-border">'.$student->nonverbal_sai.'</td>
                <td class="normal-border">'.$student->nonverbal_percentile.'</td>
                <td class="normal-border">'.$student->nonverbal_stanine.'</td>
                <td class="normal-border">'.$student->nonverbal_classification.'</td>
                <td class="normal-border">'.$student->total_raw.'</td>
                <td class="normal-border">'.$student->total_scaled.'</td>
                <td class="normal-border">'.$student->total_sai.'</td>
                <td class="normal-border" width="15px">'.$student->total_percentile.'</td>
                <td class="normal-border" width="15px">'.$student->total_stanine.'</td>
                <td class="normal-border">'.$student->total_classification.'</td>
                <td class="normal-border">'.$student->age_year.'</td>
                <td class="normal-border">'.$student->age_year.'</td>
            </tr>
            ';
            $i++;
            }
            $output .= '
        </table>

        </div>

        </main>
        </body>
        </html>
    ';
     return $output;
    }


}
