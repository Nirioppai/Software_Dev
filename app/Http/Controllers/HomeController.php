<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RawScoreToScaledScore;
use App\SaiToPercentileRankAndStanine;
use App\ScaledScoreToSai;
use App\StudentRemark;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function landing()
    {
      return view('landing');
    }
    
    public function index()
    {
        return view('home');
    }
    // public function students()
    // {
    //     return view('students');
    // }
    public function csv()
    {
        $success = ('idle');
        return view('csv')->with('success', $success);

    }

    public function studentslist()
    {
        return view('students');
    }

    // public function monitoring()
    // {
    //     return view('monitoring');
    // }
    //
    // public function monitoring_verbal()
    // {
    //   return view('monitoring_verbal');
    // }
    //
    // public function monitoring_nonverbal()
    // {
    //   return view('monitoring_nonverbal');
    // }

        public function uploadStudent()
    {
        return view('csv_student_upload');
    }

    public function StudentRemark(Request $request) {
        $this->validate($request, [
          'student_remark' => ['required'],
      ]);


        $student_number = $request->student_id;
        $student_remark = $request->student_remark;

        $student_id = DB::table('student_remarks')->where('key',  $student_number)->pluck('key')->first();
        if($student_id != $student_number)
        {
            //insert
            $Remark = new StudentRemark;
            $Remark->key = $request->student_id;
            $Remark->remarks = $request->student_remark;
        
            $Remark->save();
        }

        else{


            $update = StudentRemark::where('key', $student_number)->update(['remarks' => $student_remark]);
            return back();
        }

        //update


        return back();

    }

    public function uploadReferences()
    {

        $scaledCount = RawScoreToScaledScore::all();
        $stanineCount = SaiToPercentileRankAndStanine::all();
        $saiCount = ScaledScoreToSai::all();




        if(!count($scaledCount) && !count($stanineCount) && !count($saiCount))
        {
            $step = 1.1;
            $uploader = 'scaled_scores_1';
            $success = ('idle');
            return view('csv_references')->with('success', $success)->with('uploader', $uploader)->with('step', $step);
        }


        if(count($scaledCount) || count($stanineCount) || count($saiCount))
        {
            $scaled_display = 1;
            $stanine_display = 1;
            $sai_display = 1;

            if(!count($scaledCount))
            {
                $scaled_display = 0;
            }

            if(!count($stanineCount))
            {
                $stanine_display = 0;
            }

            if(!count($saiCount))
            {
                $sai_display = 0;
            }

            return view('csv_selective_upload')->with('scaled_display', $scaled_display)->with('stanine_display', $stanine_display)->with('sai_display', $sai_display);
        }


        
    }


}
