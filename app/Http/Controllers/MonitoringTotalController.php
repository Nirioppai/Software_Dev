<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentData;
use App\FinalStudentData;
use App\RawScoreToScaledScore;
use App\ScaledScoreToSai;
use App\SaiToPercentileRankAndStanine;
use App\FinalStudentResult;
use App\StudentRemark;
use App\student_result_total;
use App\student_result_verbal;
use App\student_result_nonverbal;

use DB;

class MonitoringTotalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  // function monitor()
  // {
  //    $data = DB::table('student_result_total')->orderBy('name', 'asc')->paginate(7);
  //    $pager = 'monitorTotal';
  //
  //    return view('monitoring', compact('data'))->with('pager', $pager);
  // }

  function monitor(Request $req)
  {
    $pager = 'monitorTotal';

    if(isset($req->filterby)) {
      $paginateby = $req->filterby;
    } else {
      $paginateby = 5;
    }

    if(isset($req->orderby)) {
      $orderby = $req->orderby;
    } else {
      $orderby = "name";
    }

    if(isset($req->ordertype)) {
      $ordertype = $req->ordertype;
    } else {
      $ordertype = "asc";
    }

    if($req->search == "")
    {
        $input_search = "";
        $data = DB::table('student_result_total')->orderBy($orderby, $ordertype)->paginate($paginateby);
        $count_rows = DB::table('student_result_total')->count();
        $data->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);
        $current_page = $data->currentPage();

        return view ('monitoring', compact('data'))->with('pager' , $pager)->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype)->with('count_rows', $count_rows)->with('current_page', $current_page);
    }
    else
    {
        $paginateby = $req->filterby;
        $input_search = $req->search;
        $data = DB::table('student_result_total')->where('student_id', 'like', ''.$req->search.'%')
              ->orWhere('name', 'like', ''.$req->search.'%')
              ->orderBy($orderby, $ordertype)
              ->paginate($paginateby);

        $search_result_count = DB::table('student_result_total')->where('student_id', 'like', ''.$req->search.'%')
              ->orWhere('name', 'like', ''.$req->search.'%');

        $count_rows = $search_result_count->count();
        $data->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);
        $current_page = $data->currentPage();


        return view ('monitoring', compact('data'))->with('pager' , $pager)->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype)->with('count_rows', $count_rows)->with('current_page', $current_page);
      }
    }

  // function fetch_data(Request $request)
  // {
  //      if($request->ajax())
  //      {
  //       $query = $request->get('query');
  //       $query = str_replace(" ", "%", $query);
  //       $data = DB::table('student_result_total')
  //                     ->where('student_id', 'like', '%'.$query.'%')
  //                     ->orWhere('name', 'like', '%'.$query.'%')
  //                     ->orderBy('name', 'asc')
  //                     ->paginate(7);
  //       $pager = 'monitorTotal';
  //
  //       return view('pagination_data', compact('data'))->with('pager', $pager)->render();
  //       }
  // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($batch)
    {
        return view ('monitoring')->with('batch', $batch);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $total_score_details = DB::table('final_student_results')->find($id);
      $student_id = DB::table('final_student_results')->where('id',  $id)->pluck('student_id')->first();
      $student_remark = DB::table('student_remarks')->where('key',  $student_id)->pluck('remarks')->first();
      return view('total_score_info', compact('total_score_details'))->with('student_remark', $student_remark);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $total_score_details = DB::table('final_student_results')->find($id);
      return view('total_score_info', compact('total_score_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $edit_score_details = FinalStudentData::find($id);
      $edit_score_details->verbal_number_correct = $request->input('verbal_number_correct');
      $edit_score_details->non_verbal_number_correct = $request->input('non_verbal_number_correct');
      $edit_score_details->overall_total_score = $request->input('verbal_number_correct') + $request->input('non_verbal_number_correct');

      $edit_score_details->save();

      $total_raw = DB::table('final_student_datas')->where('id',  $id)->pluck('overall_total_score')->first();
      $total_scaled = DB::table('student_result_total')->where('id',  $id)->pluck('total_scaled_score')->first();
      $total_sai = DB::table('student_result_total')->where('id',  $id)->pluck('total_sai')->first();
      $total_percentile = DB::table('student_result_total')->where('id',  $id)->pluck('total_percentile_rank')->first();
      $total_stanine = DB::table('student_result_total')->where('id',  $id)->pluck('total_stanine')->first();

      $verbal_raw = DB::table('final_student_datas')->where('id',  $id)->pluck('verbal_number_correct')->first();
      $verbal_scaled = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_scaled_score')->first();
      $verbal_sai = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_sai')->first();
      $verbal_percentile = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_percentile_rank')->first();
      $verbal_stanine = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_stanine')->first();

      $nonverbal_raw = DB::table('final_student_datas')->where('id',  $id)->pluck('non_verbal_number_correct')->first();
      $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_scaled_score')->first();
      $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_sai')->first();
      $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_percentile_rank')->first();
      $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_stanine')->first();

      $update = FinalStudentResult::where('id', $id)->update(['total_raw' => $total_raw]);
      $update = FinalStudentResult::where('id', $id)->update(['total_scaled' => $total_scaled]);
      $update = FinalStudentResult::where('id', $id)->update(['total_sai' => $total_sai]);
      $update = FinalStudentResult::where('id', $id)->update(['total_percentile' => $total_percentile]);
      $update = FinalStudentResult::where('id', $id)->update(['total_stanine' => $total_stanine]);

      $update = FinalStudentResult::where('id', $id)->update(['verbal_raw' => $verbal_raw]);
      $update = FinalStudentResult::where('id', $id)->update(['verbal_scaled' => $verbal_scaled]);
      $update = FinalStudentResult::where('id', $id)->update(['verbal_percentile' => $verbal_percentile]);
      $update = FinalStudentResult::where('id', $id)->update(['verbal_sai' => $verbal_sai]);
      $update = FinalStudentResult::where('id', $id)->update(['verbal_stanine' => $verbal_stanine]);

      $update = FinalStudentResult::where('id', $id)->update(['nonverbal_raw' => $nonverbal_raw]);
      $update = FinalStudentResult::where('id', $id)->update(['nonverbal_scaled' => $nonverbal_scaled]);
      $update = FinalStudentResult::where('id', $id)->update(['nonverbal_percentile' => $nonverbal_percentile]);
      $update = FinalStudentResult::where('id', $id)->update(['nonverbal_sai' => $nonverbal_sai]);
      $update = FinalStudentResult::where('id', $id)->update(['nonverbal_stanine' => $nonverbal_stanine]);

      $total_score_details = FinalStudentResult::find($id);

      return view('total_score_info', compact('total_score_details'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
