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


class ChartController extends Controller
{
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

        $MeanTable = MeanResults::all();
        $isEmpty = 1;

        
        if(!count($MeanTable))
        {
            $isEmpty = 1;
        }

        else if(count($MeanTable))
        {
            $isEmpty = 0;
        }



        return view('home')->with('OLSATBar', $OLSATBar)->with('OLSATLine', $OLSATLine)->with('filterSelected', $filterSelected)->with('batchSelected', $batchSelected)->with('meanResults', $meanResults)->with('isEmpty', $isEmpty);
        
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
        
        $MeanTable = MeanResults::all();
        $isEmpty = 1;

        
        if(!count($MeanTable))
        {
            $isEmpty = 1;
        }

        else if(count($MeanTable))
        {
            $isEmpty = 0;
        }
        
            
            

        return view('home')->with('OLSATBar', $OLSATBar)->with('OLSATLine', $OLSATLine)->with('filterSelected', $filterSelected)->with('batchSelected', $batchSelected)->with('meanResults', $meanResults)->with('isEmpty', $isEmpty);
     }
}
