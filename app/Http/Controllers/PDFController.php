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
     $batch_results = DB::table('final_student_results')->where('batch',  $batch)->get();

     $pdf = PDF::loadView('student_result_batch_export', array('batch_results' => $batch_results));
     return $pdf->download('Batch.pdf');
    }

    function pdf($batch)
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_student_results_to_html($batch));
     return $pdf->stream();
    }

    function convert_student_results_to_html($batch)
    {
     $student_results = $this->exportBatch($batch);
     $output = '
     <h3 align="center">student Data</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:5px;" width="1%">Name</th>
    <th style="border: 1px solid; padding:5px;" width="1%">Address</th>
    <th style="border: 1px solid; padding:5px;" width="1%">City</th>
    <th style="border: 1px solid; padding:5px;" width="1%">City</th>
   </tr>
     ';  
     foreach($student_results as $student)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:5px;">'.$student->id.'</td>
       <td style="border: 1px solid; padding:5px;">'.$student->name.'</td>
      </tr>
      ';
     }
     $output .= '</table>';
     return $output;
    }


}
