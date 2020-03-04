<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use DB;

class PDFController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
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

    function pdf_batch_tabular($batch)
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_student_results_to_html_tabular($batch))->setPaper('legal', 'landscape');
     //return $pdf->stream();
     return $pdf->download('Student Tabular Results Batch '.$batch. '.pdf');
    }


    function pdf_batch_individual($batch)
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_student_results_to_html_individual($batch));
     //return $pdf->stream();
     return $pdf->download('Student Individual Results Batch '.$batch. '.pdf');
    }

    function convert_student_results_to_html_individual($batch)
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
            ';
            $i = 1;  
            foreach($student_results as $student)
            {
            $output .= '
            
            
        <body class="body">
            <header class="header-individual">
            <img style="width: 100%; height: 100%;" src="./img/pdf/PDF_header.png"> 
            </header>
                            
        <main class ="main-individual">
        <div>
        <p class="student-name">Name: '.$student->student_name.'</p>
        
        <br>
        Grade & Section: '.$student->grade. '-'.' '.$student->section.'
        <br>
        School: Xavier School San Juan
        <br>
        School Year:

        <p class="date-of-testing">Date of Testing: '.$student->exam_date.'</p>

        <p class="date-of-birth">Date of Birth: '.$student->birthday.'</p>

        <p class="age">Age: '.$student->age_year. '-'.' '.$student->age_month.'</p>
        

            <center>
            <h3>
                <b>INDIVIDUAL SUMMARY REPORT</b>
            </h3>
            </center>

        <br>


        
        <table class="minify" width="100%" style="border-collapse: collapse; border: 0px;">
               <tr>
                    <th class="center-cell" width="0.3%" >Cluster/Item Type</th>
                    <th class="center-cell" width="0.3%" >Number of Items</th>
                    <th class="center-cell" width="0.3%" >Raw Score</th>
                    <th class="center-cell" width="0.3%" >Scaled
                    Score</th>
                    <th class="center-cell" width="0.3%" >School
                    Ability
                    Index</th>
                    <th class="center-cell" width="0.3%" >Age
                    Percentile
                    Rank</th>
                    <th class="center-cell" width="0.3%" >Stanine</th>
                    <th class="center-cell" width="0.3%" >Classification</th>
                </tr>

                <tr>
                        <td class="left-cell">Verbal</td>
                        <td class="center-cell">36</td>
                        <td class="center-cell">'.$student->verbal_raw.'</td>
                        <td class="center-cell">'.$student->verbal_scaled.'</td>
                        <td class="center-cell">'.$student->verbal_sai.'</td>
                        <td class="center-cell">'.$student->verbal_percentile.'</td>
                        <td class="center-cell">'.$student->verbal_stanine.'</td>
                        <td class="center-cell">'.$student->verbal_classification.'</td>
                    </tr>

                    <tr>
                        <td class="normal-cell">Verbal Comprehension</td>
                        <td class="center-cell">12</td>
                        <td class="center-cell">'.$student->verbal_comprehension.'</td>
                        <td class="center-cell" colspan="5" rowspan="2"></td>
                    </tr>

                    <tr>
                        <td class="normal-cell">Verbal Reasoning</td>
                        <td class="center-cell">24</td>
                        <td class="center-cell">'.$student->verbal_reasoning.'</td>
                    </tr>

                    <tr>
                        <td class="left-cell">Non-Verbal</td>
                        <td class="center-cell">36</td>
                        <td class="center-cell">'.$student->nonverbal_raw.'</td>
                        <td class="center-cell">'.$student->nonverbal_scaled.'</td>
                        <td class="center-cell">'.$student->nonverbal_sai.'</td>
                        <td class="center-cell">'.$student->nonverbal_percentile.'</td>
                        <td class="center-cell">'.$student->nonverbal_stanine.'</td>
                        <td class="center-cell">'.$student->nonverbal_classification.'</td>
                    </tr>

                    <tr>
                        <td class="normal-cell">Figural Reasoning</td>
                        <td class="center-cell">18</td>
                        <td class="center-cell">'.$student->figural_reasoning.'</td>
                        <td class="center-cell" colspan="5" rowspan="2"></td>
                    </tr>
                    
                    <tr>
                        <td class="normal-cell">Quantitative Reasoning</td>
                        <td class="center-cell">18</td>
                        <td class="center-cell">'.$student->quantitative_reasoning.'</td>
                    </tr>

                    <tr>
                        <td class="left-cell">Total Score</td>
                        <td class="center-cell">72</td>
                        <td class="center-cell">'.$student->total_raw.'</td>
                        <td class="center-cell">'.$student->total_scaled.'</td>
                        <td class="center-cell">'.$student->total_sai.'</td>
                        <td class="center-cell">'.$student->total_percentile.'</td>
                        <td class="center-cell">'.$student->total_stanine.'</td>
                        <td class="center-cell">'.$student->total_classification.'</td>
                    </tr>

                    </table>


                    <p class="solid">INTERPRETATIVE GUIDELINES</p>

                    <p class="normal">
                This school ability test aims to measure a student’s innate capacity to learn and his/her level of ability to scope with schoolwork. This test is divided
                into two clusters – <b>Verbal</b> and <b>Non Verbal</b>.


                    </p>

                    <p class="normal">
                    The <b>VERBAL</b> cluster consists of Verbal Comprehension and Verbal Reasoning. The <b>Verbal Comprehension</b> includes questions that assess the
ability to observe and understand relationships between words, to understand different meanings of words based on context, and to be able to put
words and sentences together in a meaningful way. The <b>Verbal Reasoning</b> includes questions that assess the ability to ascertain relationships
between words, apply inferences to different scenarios, and observe differences and similarities.

                    </p>

                    <p class="normal">
                    The <b>NON-VERBAL</b> cluster consists of Figural and Quantitative Reasoning. The <b>Figural Reasoning</b> includes questions that assess the ability to use
geometric shapes and figures to infer relationships, understand and continue progressions, and compare and contrast different figures. The
<b>Quantitative Reasoning</b> includes questions that assesses the ability to infer relationships with numbers, and deduce and use computational rules
in context.

                    </p>


                    <p class="normal">
                    The test yields raw scores which are converted to scaled scores, school ability indeces, percentile ranks and stanines. The <b>Raw Score</b> is the sum
total of correctly answered questions. The <b>School Ability Index</b> score is determined by comparing raw scores amongst children within the same
age group. <b>Percentile Rank</b> is the relative standing of a student in comparison with other students in the same age group who took the test at the
same time of the year. <b>Stanines</b> are normalized standard scores with a range of 1 to 9 and mean of 5. The scores are classified as follows:

                    </p>


                    <p class="normal">
                    <b>Above Average</b>. Students with stanine between 7 - 9 are classified as Above Average. Above average rating is indicative of strong potential to
succeed in completing academic tasks. Students with above average rating show high level of mastery and comprehension of the cluster(s)
assessed. Students in this rating require little to no support in completing academic requirements.
<br>
<b>Average</b>. Students with stanine between 4 - 6 are classified as average. Average rating is indicative of adequate ability to succeed in completing
academic tasks. Students with average rating show progressive mastery and comprehension of the cluster(s) assessed. Students in this rating may
require support in completing academic requirements.
<br>
<b>Below Average</b>. Students with stanine between 1 -3 are classified as Below Average. Students with below average rating show low level of mastery
and comperehension of the cluster(s) assessed. Students in this rating will need substantial support in completing academic requirements.
                    </p>

        </div>

        </main>
        </body>
        
            
            ';
            $i++;
            }
            $output .= '

            </html>
        
    ';
     return $output;
    }

    function convert_student_results_to_html_tabular($batch)
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
        <table width="97%" style="border-collapse: collapse; border: 0px;">
            <thead>
                <tr>
  	<th class="normal-border" width="0.3%" rowspan="4">No.</th>
  	<th class="normal-border" width="0.3%" rowspan="4">Name</th>
  	<th class="normal-border" width="0.3%" rowspan="4">Birthday</th>
  	<th class="normal-border" width="0.3%" rowspan="4">Age</th>
    <th class="normal-border" width="0.3%" colspan="8">Verbal</th>
    <th class="normal-border" width="0.3%" colspan="8">Non Verbal</th>
    <th class="normal-border" width="0.3%" colspan="6">Total Score</th>
    

    
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
