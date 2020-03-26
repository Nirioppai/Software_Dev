<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RawScoreToScaledScore;
use App\SaiToPercentileRankAndStanine;
use App\ScaledScoreToSai;
use App\StudentRemark;
use App\MeanResults;
use App\User;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Charts\UserChart;

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
        $maxBatch = DB::table('mean_results')->max('batch');
        $batchEntries = DB::table('mean_results')->get();
        
        $batchSelected = $maxBatch;
        $BelowAverageBorderColors = [
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
        ];
        $BelowAverageFillColors = [
            "rgba(79, 129, 189, 0.2)",
            "rgba(79, 129, 189, 0.2)",
            "rgba(79, 129, 189, 0.2)",
        ];

        $AverageBorderColors = [
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
        ];
        $AverageFillColors = [
            "rgba(192, 80, 77, 0.2)",
            "rgba(192, 80, 77, 0.2)",
            "rgba(192, 80, 77, 0.2)",
        ];

        $AboveAverageBorderColors = [
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
        ];
        $AboveAverageFillColors = [
            "rgba(155, 187, 89, 0.2)",
            "rgba(155, 187, 89, 0.2)",
            "rgba(155, 187, 89, 0.2)",
        ];
        $below_average_verbal_count = DB::table('student_batch')->where('batch',  1)->where('verbal_classification',  'Below Average')->pluck('verbal_classification');
        $average_verbal_count = DB::table('student_batch')->where('batch',  1)->where('verbal_classification',  'Average')->pluck('verbal_classification');
        $above_average_verbal_count = DB::table('student_batch')->where('batch',  1)->where('verbal_classification',  'Above Average')->pluck('verbal_classification');

        $below_average_nonverbal_count = DB::table('student_batch')->where('batch',  1)->where('nonverbal_classification',  'Below Average')->pluck('nonverbal_classification');
        $average_nonverbal_count = DB::table('student_batch')->where('batch',  1)->where('nonverbal_classification',  'Average')->pluck('nonverbal_classification');
        $above_average_nonverbal_count = DB::table('student_batch')->where('batch',  1)->where('nonverbal_classification',  'Above Average')->pluck('nonverbal_classification');

        $below_average_total_count = DB::table('student_batch')->where('batch',  1)->where('total_classification',  'Below Average')->pluck('total_classification');
        $average_total_count = DB::table('student_batch')->where('batch',  1)->where('total_classification',  'Average')->pluck('total_classification');
        $above_average_total_count = DB::table('student_batch')->where('batch',  1)->where('total_classification',  'Above Average')->pluck('total_classification');
 
        $below_average_verbal_count = count($below_average_verbal_count);
        $average_verbal_count = count($average_verbal_count);
        $above_average_verbal_count = count($above_average_verbal_count);

        $below_average_nonverbal_count = count($below_average_nonverbal_count);
        $average_nonverbal_count = count($average_nonverbal_count);
        $above_average_nonverbal_count = count($above_average_nonverbal_count);

        $below_average_total_count = count($below_average_total_count);
        $average_total_count = count($average_total_count);
        $above_average_total_count = count($above_average_total_count);

        $OLSATBar = new UserChart;
        $OLSATBar->minimalist(false);
        $OLSATBar->labels(['Verbal', 'Nonverbal', 'Total Score']);
        $OLSATBar->title('Batch '. $batchSelected);
        $OLSATBar->dataset('Below Average', 'bar', [$below_average_verbal_count, $below_average_nonverbal_count, $below_average_total_count],)
            ->color($BelowAverageBorderColors)
            ->backgroundcolor($BelowAverageFillColors);
            /*
            ->color(collect(['#4f81bd','#c0504d', '#9bbb59']))
            ->backgroundcolor(collect(['#4f81bd','#c0504d', '#9bbb59']));
            */
        $OLSATBar->dataset('Average', 'bar', [$average_verbal_count, $average_nonverbal_count, $average_total_count],)
        ->color($AverageBorderColors)
        ->backgroundcolor($AverageFillColors);

        $OLSATBar->dataset('Above Average', 'bar', [$above_average_verbal_count, $above_average_nonverbal_count, $above_average_total_count],)
        ->color($AboveAverageBorderColors)
        ->backgroundcolor($AboveAverageFillColors);


        $data = collect([]); // Could also be an array
        $verbal = collect([]);
        $nonverbal = collect([]);
        $total = collect([]);
        $selector = "Raw";
        

        $maxBatch = DB::table('mean_results')->max('batch');
        
        $meanResults = DB::table('mean_results')->get();

        //disables inclusion of deleted batch
        foreach ($meanResults as $meanRow) {
            $data->push('Batch '.$meanRow->batch);
    
            $verbalSelect = DB::table('mean_results')->where('batch',  $meanRow->batch)->pluck('AverageVerbal'.$selector);
            $nonverbalSelect = DB::table('mean_results')->where('batch',  $meanRow->batch)->pluck('AverageNonVerbal'.$selector);
            $totalSelect = DB::table('mean_results')->where('batch',  $meanRow->batch)->pluck('AverageTotal'.$selector);
        
            $verbal->push($verbalSelect);
            $nonverbal->push($nonverbalSelect);
            $total->push($totalSelect);
        }


        $BelowAverageBorderColors = [
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
        ];
        $BelowAverageFillColors = [
            "rgba(79, 129, 189, 0.1)",
            "rgba(79, 129, 189, 0.1)",
            "rgba(79, 129, 189, 0.1)",
        ];

        $AverageBorderColors = [
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
        ];
        $AverageFillColors = [
            "rgba(192, 80, 77, 0.1)",
            "rgba(192, 80, 77, 0.1)",
            "rgba(192, 80, 77, 0.1)",
        ];

        $AboveAverageBorderColors = [
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
        ];
        $AboveAverageFillColors = [
            "rgba(155, 187, 89, 0.1)",
            "rgba(155, 187, 89, 0.1)",
            "rgba(155, 187, 89, 0.1)",
        ];



        $OLSATLine = new UserChart;
        $OLSATLine->minimalist(false);
        $OLSATLine->labels($data);
        $OLSATLine->title($selector.'Score trend');

        $OLSATLine->dataset('Verbal', 'line', $verbal->values())
            ->color($BelowAverageBorderColors)
            ->backgroundcolor($BelowAverageFillColors);

        $OLSATLine->dataset('Nonverbal', 'line', $nonverbal->values())
            ->color($AverageBorderColors)
            ->backgroundcolor($AverageFillColors);
        
        $OLSATLine->dataset('Total', 'line', $total->values())
            ->color($AboveAverageBorderColors)
            ->backgroundcolor($AboveAverageFillColors);

        $filterSelected = $selector;

        return view('home2')->with('OLSATBar', $OLSATBar)->with('OLSATLine', $OLSATLine)->with('filterSelected', $filterSelected)->with('batchSelected', $batchSelected)->with('meanResults', $meanResults);
        
    }

     public function homeSort($batch, Request $request)
     {

        $batchSelected = $request->input('batchFilter');
        $selector = $request->input('fieldFilter');

        $BelowAverageBorderColors = [
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
        ];
        $BelowAverageFillColors = [
            "rgba(79, 129, 189, 0.2)",
            "rgba(79, 129, 189, 0.2)",
            "rgba(79, 129, 189, 0.2)",
        ];

        $AverageBorderColors = [
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
        ];
        $AverageFillColors = [
            "rgba(192, 80, 77, 0.2)",
            "rgba(192, 80, 77, 0.2)",
            "rgba(192, 80, 77, 0.2)",
        ]; 

        $AboveAverageBorderColors = [
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
        ];
        $AboveAverageFillColors = [
            "rgba(155, 187, 89, 0.2)",
            "rgba(155, 187, 89, 0.2)",
            "rgba(155, 187, 89, 0.2)",
        ];
        $below_average_verbal_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('verbal_classification',  'Below Average')->pluck('verbal_classification');
        $average_verbal_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('verbal_classification',  'Average')->pluck('verbal_classification');
        $above_average_verbal_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('verbal_classification',  'Above Average')->pluck('verbal_classification');
        
        $below_average_nonverbal_count = DB::table('student_batch')->where('batch', $batchSelected)->where('nonverbal_classification',  'Below Average')->pluck('nonverbal_classification');
        $average_nonverbal_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('nonverbal_classification',  'Average')->pluck('nonverbal_classification');
        $above_average_nonverbal_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('nonverbal_classification',  'Above Average')->pluck('nonverbal_classification');
        
        $below_average_total_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('total_classification',  'Below Average')->pluck('total_classification');
        $average_total_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('total_classification',  'Average')->pluck('total_classification');
        $above_average_total_count = DB::table('student_batch')->where('batch',  $batchSelected)->where('total_classification',  'Above Average')->pluck('total_classification');
        
        $below_average_verbal_count = count($below_average_verbal_count);
        $average_verbal_count = count($average_verbal_count);
        $above_average_verbal_count = count($above_average_verbal_count);

        $below_average_nonverbal_count = count($below_average_nonverbal_count);
        $average_nonverbal_count = count($average_nonverbal_count);
        $above_average_nonverbal_count = count($above_average_nonverbal_count);

        $below_average_total_count = count($below_average_total_count);
        $average_total_count = count($average_total_count);
        $above_average_total_count = count($above_average_total_count);

        $OLSATBar = new UserChart;
        $OLSATBar->minimalist(false);
        $OLSATBar->labels(['Verbal', 'Nonverbal', 'Total Score']);
        $OLSATBar->title('Batch '. $batchSelected);
        $OLSATBar->dataset('Below Average', 'bar', [$below_average_verbal_count, $below_average_nonverbal_count, $below_average_total_count],)
            ->color($BelowAverageBorderColors)
            ->backgroundcolor($BelowAverageFillColors);
            /*
            ->color(collect(['#4f81bd','#c0504d', '#9bbb59']))
            ->backgroundcolor(collect(['#4f81bd','#c0504d', '#9bbb59']));
            */
        $OLSATBar->dataset('Average', 'bar', [$average_verbal_count, $average_nonverbal_count, $average_total_count],)
        ->color($AverageBorderColors)
        ->backgroundcolor($AverageFillColors);

        $OLSATBar->dataset('Above Average', 'bar', [$above_average_verbal_count, $above_average_nonverbal_count, $above_average_total_count],)
        ->color($AboveAverageBorderColors)
        ->backgroundcolor($AboveAverageFillColors);


        $data = collect([]); // Could also be an array
        $verbal = collect([]);
        $nonverbal = collect([]);
        $total = collect([]);
        

        $maxBatch = DB::table('mean_results')->max('batch');
        
        $meanResults = DB::table('mean_results')->get();

        //disables inclusion of deleted batch
        foreach ($meanResults as $meanRow) {
                $data->push('Batch '.$meanRow->batch);
        
                $verbalSelect = DB::table('mean_results')->where('batch',  $meanRow->batch)->pluck('AverageVerbal'.$selector);
                $nonverbalSelect = DB::table('mean_results')->where('batch',  $meanRow->batch)->pluck('AverageNonVerbal'.$selector);
                $totalSelect = DB::table('mean_results')->where('batch',  $meanRow->batch)->pluck('AverageTotal'.$selector);
            
                $verbal->push($verbalSelect);
                $nonverbal->push($nonverbalSelect);
                $total->push($totalSelect);
            }





        


        $BelowAverageBorderColors = [
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
            "rgba(79, 129, 189, 1.0)",
        ];
        $BelowAverageFillColors = [
            "rgba(79, 129, 189, 0.1)",
            "rgba(79, 129, 189, 0.1)",
            "rgba(79, 129, 189, 0.1)",
        ];

        $AverageBorderColors = [
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
            "rgba(192, 80, 77, 1.0)",
        ];
        $AverageFillColors = [
            "rgba(192, 80, 77, 0.1)",
            "rgba(192, 80, 77, 0.1)",
            "rgba(192, 80, 77, 0.1)",
        ];

        $AboveAverageBorderColors = [
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
            "rgba(155, 187, 89, 1.0)",
        ];
        $AboveAverageFillColors = [
            "rgba(155, 187, 89, 0.1)",
            "rgba(155, 187, 89, 0.1)",
            "rgba(155, 187, 89, 0.1)",
        ];



        $OLSATLine = new UserChart;
        $OLSATLine->minimalist(false);
        $OLSATLine->labels($data);
        $OLSATLine->title($selector.'Score trend');

        $OLSATLine->dataset('Verbal', 'line', $verbal->values())
            ->color($BelowAverageBorderColors)
            ->backgroundcolor($BelowAverageFillColors);

        $OLSATLine->dataset('Nonverbal', 'line', $nonverbal->values())
            ->color($AverageBorderColors)
            ->backgroundcolor($AverageFillColors);
        
        $OLSATLine->dataset('Total', 'line', $total->values())
            ->color($AboveAverageBorderColors)
            ->backgroundcolor($AboveAverageFillColors);

        $filterSelected = $selector;
        

        
            
            

        return view('home2')->with('OLSATBar', $OLSATBar)->with('OLSATLine', $OLSATLine)->with('filterSelected', $filterSelected)->with('batchSelected', $batchSelected)->with('meanResults', $meanResults);
     }

    public function register()
    {
        $Users = User::all();
        return view('account_register')->with('Users',$Users);
    }

    public function registerSubmit(Request $request)
    {
        $this->validate($request, [
          'name' => ['required', 'string', 'max:50'],
          'username' => ['required', 'string', 'max:25', 'unique:users'],
          'password' => ['required', 'confirmed', 'string', 'max:25', 'min:8'],
      ]);

      //Registers the User
      $UserDB = new User;
      $UserDB->name = $request->input('name');
      $UserDB->username = $request->input('username');
      $UserDB->password =  Hash::make($request->input('password'));
      $UserDB->save();

      return redirect('/home/register');
    }

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
            $warning = false;
            $step = 1.1;
            $uploader = 'scaled_scores_1';
            $success = ('idle');

            return view('csv_references')->with('success', $success)->with('uploader', $uploader)->with('step', $step)->with('warning', $warning);
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
