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
            <footer style ="padding-left: 3%;">
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
                
                <h1 align="center">OTIS-LENNON SCHOOL ABILITY TEST 8th Ed. Level F</h1>
                <h2 align="center">Masterlist Report</h2>
                <p class="enlarged" style ="padding-left: 3%;">
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
                    <th class="normal-border" width="0.3%" colspan="2" rowspan="3">Normal Curve Equivalent</th>
                </tr>

                <tr>
                    <th class="normal-border" width="0.3%" rowspan="1">Verbal Comprehension</th>
                    <th class="normal-border" width="0.3%" rowspan="1">Verbal Reasoning</th>
                    <th class="normal-border" width="0.3%" colspan="6">Total Verbal</th>
                    <!--Verbal-->
                    <th class="normal-border" width="0.3%">Figural Reasoning</th>
                    <th class="normal-border" width="0.3%">Quantitative Reasoning</th>
                    <th class="normal-border" width="0.3%" colspan="6">Total Non Verbal</th>
                    <!--Non Verbal-->

                    <th class="normal-border" width="0.3%" rowspan="3">RS</th>
                    <th class="normal-border" width="0.3%" rowspan="3">SS</th>
                    <th class="normal-border" width="0.3%" colspan="4" rowspan="2">Age Norms</th>
                    
                </tr>

                <tr>
                    <th class="normal-border" width="0.3%" rowspan="2">RS</th>
                    <th class="normal-border" width="0.3%" rowspan="2">RS</th>

                    <th class="normal-border" width="0.3%" rowspan="2">RS</th>
                    <th class="normal-border" width="0.3%" rowspan="2">SS</th>
                    <th class="normal-border" width="0.3%" colspan="4">Age Norms</th>
                    <!--Verbal-->
                    <th class="normal-border" width="0.3%" rowspan="2">RS</th>
                    <th class="normal-border" width="0.3%" rowspan="2">RS</th>

                    <th class="normal-border" width="0.3%" rowspan="2">RS</th>
                    <th class="normal-border" width="0.3%" rowspan="2">SS</th>
                    <th class="normal-border" width="0.3%" colspan="4">Age Norms</th>
                    <!--Non Verbal-->

                    
                    
                </tr>

                <tr>
                    <th class="normal-border" width="0.3%">SAI</th>
                    <th class="normal-border" width="0.3%">PR</th>
                    <th class="normal-border" width="0.3%">S</th>
                    <th class="normal-border" width="0.3%">CL</th>
                    <!--Verbal-->
                    <th class="normal-border" width="0.3%">SAI</th>
                    <th class="normal-border" width="0.3%">PR</th>
                    <th class="normal-border" width="0.3%">S</th>
                    <th class="normal-border" width="0.3%">CL</th>
                    <!--Non Verbal-->
                    <th class="normal-border" width="0.3%">SAI</th>
                    <th class="normal-border" width="0.3%">PR</th>
                    <th class="normal-border" width="0.3%">S</th>
                    <th class="normal-border" width="0.3%">CL</th>
                    <th class="normal-border" width="0.3%">Age</th>
                    <th class="normal-border" width="0.3%">Grade</th>
                </tr>

            </thead>
            ';  
            foreach($student_results as $student)
            {
            $output .= '
            <tr>
                <td class="normal-border">1</td>
                <td class="normal-border">2</td>
                <td class="normal-border">3</td>
                <td class="normal-border">4</td>
                <td class="normal-border">5</td>
                <td class="normal-border">6</td>
                <td class="normal-border">7</td>
                <td class="normal-border">8</td>
                <td class="normal-border">9</td>
                <td class="normal-border">10</td>
                <td class="normal-border">11</td>
                <td class="normal-border">12</td>
                <td class="normal-border">13</td>
                <td class="normal-border">14</td>
                <td class="normal-border">15</td>
                <td class="normal-border">16</td>
                <td class="normal-border">17</td>
                <td class="normal-border">18</td>
                <td class="normal-border">19</td>
                <td class="normal-border">20</td>
                <td class="normal-border">21</td>
                <td class="normal-border">22</td>
                <td class="normal-border">23</td>
                <td class="normal-border">24</td>
                <td class="normal-border">25</td>
                <td class="normal-border">26</td>
                <td class="normal-border">27</td>
                <td class="normal-border">28</td>
            </tr>
            ';
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
