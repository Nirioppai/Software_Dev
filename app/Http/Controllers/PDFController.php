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

        $student_details = DB::table('final_student_datas')->where('student_id',  $request->student_no)->first();
        $verbal_details = DB::table('student_result_verbal')->where('student_id',  $request->student_no)->first();
        $total_details = DB::table('student_result_total')->where('student_id',  $request->student_no)->first();
        $nonverbal = DB::table('student_result_nonverbal')->where('student_id',  $request->student_no)->first();



        $pdf = PDF::loadView('student_result_export', 
            array('student_details' => $student_details), 
            array('verbal_details' => $verbal_details), 
            array('total_details' => $total_details), 
            array('nonverbal' => $nonverbal));

        return $pdf->stream();
    }

    public function savePDF(Request $request)
    {

        $student_number = $request->student_no;

        $student_details = DB::table('final_student_datas')->where('student_id',  $request->student_no)->first();
        $verbal = DB::table('student_result_verbal')->where('student_id',  $request->student_no)->first();
        $total = DB::table('student_result_total')->where('student_id',  $request->student_no)->first();
        $nonverbal = DB::table('student_result_nonverbal')->where('student_id',  $request->student_no)->first();



        $pdf = PDF::loadView('student_result_export', array('student_details' => $student_details), array('verbal' => $verbal), array('total' => $total), array('nonverbal' => $nonverbal));
        return $pdf->download('Student Result '.$student_number. '.pdf');
    }
}
