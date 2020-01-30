<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\student_result_total;
use DB;

class PDFController extends Controller
{
    public function viewPDF(Request $request)
    {

    	$student_number = $request->student_no;

    	$student_number = DB::table('student_result_total')->where('student_id',  $request->student_no)->first();

    	$pdf = PDF::loadView('student_result_export', array('student_number' => $student_number));
		return $pdf->stream();




    	

    }
}
