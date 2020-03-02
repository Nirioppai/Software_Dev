<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\student_data;
use App\FinalStudentData;
use App\FinalStudentResult;
use DB;

class LiveSearchController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

    function students(Request $req)
  {
    $pager = 'student';

    if(isset($req->filterby)) {
      $paginateby = $req->filterby;
    } else {
      $paginateby = 5;
    }

    if(isset($req->orderby)) {
      $orderby = $req->orderby;
    } else {
      $orderby = "student_name";
    }

    if(isset($req->ordertype)) {
      $ordertype = $req->ordertype;
    } else {
      $ordertype = "asc";
    }

    if($req->search == "")
    {
        $input_search = "";
        $data = DB::table('final_student_datas')->orderBy($orderby, $ordertype)->paginate($paginateby);
        $count_rows = DB::table('final_student_datas')->count();
        $data->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);
        $current_page = $data->currentPage();

        return view ('students_view', compact('data'))->with('pager' , $pager)->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype)->with('count_rows', $count_rows)->with('current_page', $current_page);
    }
    else
    {
        $paginateby = $req->filterby;
        $input_search = $req->search;
        $data = DB::table('final_student_datas')->where('student_id', 'like', ''.$req->search.'%')
              ->orWhere('student_name', 'like', ''.$req->search.'%')
              ->orWhere('birthday', 'like', ''.$req->search.'%')
              ->orderBy($orderby, $ordertype)
              ->paginate($paginateby);

        $search_result_count = DB::table('final_student_datas')->where('student_id', 'like', ''.$req->search.'%')
              ->orWhere('student_name', 'like', ''.$req->search.'%')
              ->orWhere('birthday', 'like', ''.$req->search.'%');

        $count_rows = $search_result_count->count();
        $data->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);
        $current_page = $data->currentPage();


        return view ('students_view', compact('data'))->with('pager' , $pager)->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype)->with('count_rows', $count_rows)->with('current_page', $current_page);
    }

  }


 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function index()
 {
     //
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
    $student_details = DB::table('final_student_datas')->find($id);
    return view('student_info', compact('student_details'));

 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit($id)
 {
   $student_details = FinalStudentData::find($id);

   return view('edit_student_info', compact('student_details'));
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
   $student_details = FinalStudentData::find($id);

   $student_details->student_name = $request->input('student_name');
   $student_details->student_id = $request->input('student_id');
   $student_details->grade = $request->input('grade');
   $student_details->section = $request->input('section');
   $student_details->birthday = $request->input('birthday');
   $student_details->exam_date = $request->input('exam_date');

   $student_details->save();

   // UPDATE AGE

   // Student ID ng ieedit
   $student_id = $student_details->student_id;

   // pluck yung nasa view
   $rounded_current_age_in_years = DB::table('student_age')->where('student_id',  $student_id)->pluck('rounded_current_age_in_years')->first();
   $rounded_current_age_in_months = DB::table('student_age')->where('student_id',  $student_id)->pluck('rounded_current_age_in_months')->first();
   $current_age_in_days = DB::table('student_age')->where('student_id',  $student_id)->pluck('current_age_in_days')->first();

   // ilagay yung nasa view to final_student_datas
   $update = FinalStudentData::where('student_id', $student_id)->update(['rounded_current_age_in_years' => $rounded_current_age_in_years]);
   $update = FinalStudentData::where('student_id', $student_id)->update(['rounded_current_age_in_months' => $rounded_current_age_in_months]);
   $update = FinalStudentData::where('student_id', $student_id)->update(['current_age_in_days' => $current_age_in_days]);

   //update results
   $student_name = DB::table('final_student_datas')->where('id',  $id)->pluck('student_name')->first();
   $student_id = DB::table('final_student_datas')->where('id',  $id)->pluck('student_id')->first();
   $grade = DB::table('final_student_datas')->where('id',  $id)->pluck('grade')->first();
   $section = DB::table('final_student_datas')->where('id',  $id)->pluck('section')->first();
   $birthday = DB::table('final_student_datas')->where('id',  $id)->pluck('birthday')->first();
   $exam_date = DB::table('final_student_datas')->where('id',  $id)->pluck('exam_date')->first();
   $rounded_current_age_in_years = DB::table('final_student_datas')->where('id',  $id)->pluck('rounded_current_age_in_years')->first();
   $rounded_current_age_in_months = DB::table('final_student_datas')->where('id',  $id)->pluck('rounded_current_age_in_months')->first();
   $current_age_in_days = DB::table('final_student_datas')->where('id',  $id)->pluck('current_age_in_days')->first();


   $update = FinalStudentResult::where('id', $id)->update(['student_name' => $student_name]);
   $update = FinalStudentResult::where('id', $id)->update(['student_id' => $student_id]);
   $update = FinalStudentResult::where('id', $id)->update(['grade' => $grade]);
   $update = FinalStudentResult::where('id', $id)->update(['section' => $section]);
   $update = FinalStudentResult::where('id', $id)->update(['birthday' => $birthday]);
   $update = FinalStudentResult::where('id', $id)->update(['exam_date' => $exam_date]);
   $update = FinalStudentResult::where('id', $id)->update(['rounded_current_age_in_years' => $rounded_current_age_in_years]);
   $update = FinalStudentResult::where('id', $id)->update(['rounded_current_age_in_months' => $rounded_current_age_in_months]);

   // Update Scores

   $totalID = DB::table('student_result_total')->where('id',  $id)->exists();
   $verbalID = DB::table('student_result_verbal')->where('id',  $id)->exists();
   $nonverbalID = DB::table('student_result_nonverbal')->where('id',  $id)->exists();

   if ($totalID == true && $verbalID == true && $nonverbalID == true)
   {
     $total_raw = DB::table('final_student_datas')->where('id',  $id)->pluck('total_score')->first();
     $total_scaled = DB::table('student_result_total')->where('id',  $id)->pluck('total_scaled_score')->first();
     $total_sai = DB::table('student_result_total')->where('id',  $id)->pluck('total_sai')->first();
     $total_percentile = DB::table('student_result_total')->where('id',  $id)->pluck('total_percentile_rank')->first();
     $total_stanine = DB::table('student_result_total')->where('id',  $id)->pluck('total_stanine')->first();

     $total_classification = DB::table('student_result_total')->where('id',  $id)->pluck('total_classification')->first();

     $verbal_raw = DB::table('final_student_datas')->where('id',  $id)->pluck('verbal_total_score')->first();
     $verbal_scaled = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_scaled_score')->first();
     $verbal_sai = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_sai')->first();
     $verbal_percentile = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_percentile_rank')->first();
     $verbal_stanine = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_stanine')->first();

     $verbal_comprehension = DB::table('final_student_datas')->where('id',  $id)->pluck('verbal_comprehension')->first();
     $verbal_reasoning = DB::table('final_student_datas')->where('id',  $id)->pluck('verbal_reasoning')->first();
     $verbal_classification = DB::table('student_result_verbal')->where('id',  $id)->pluck('verbal_classification')->first();

     $nonverbal_raw = DB::table('final_student_datas')->where('id',  $id)->pluck('non_verbal_total_score')->first();
     $nonverbal_scaled = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_scaled_score')->first();
     $nonverbal_sai = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_sai')->first();
     $nonverbal_percentile = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_percentile_rank')->first();
     $nonverbal_stanine = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_stanine')->first();

     $quantitative_reasoning = DB::table('final_student_datas')->where('id',  $id)->pluck('quantitative_reasoning')->first();
     $figural_reasoning = DB::table('final_student_datas')->where('id',  $id)->pluck('figural_reasoning')->first();
     $nonverbal_classification = DB::table('student_result_nonverbal')->where('id',  $id)->pluck('nonverbal_classification')->first();

     $update = FinalStudentResult::where('id', $id)->update(['total_raw' => $total_raw]);
     $update = FinalStudentResult::where('id', $id)->update(['total_scaled' => $total_scaled]);
     $update = FinalStudentResult::where('id', $id)->update(['total_sai' => $total_sai]);
     $update = FinalStudentResult::where('id', $id)->update(['total_percentile' => $total_percentile]);
     $update = FinalStudentResult::where('id', $id)->update(['total_stanine' => $total_stanine]);

     $update = FinalStudentResult::where('id', $id)->update(['total_classification' => $total_classification]);

     $update = FinalStudentResult::where('id', $id)->update(['verbal_raw' => $verbal_raw]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_scaled' => $verbal_scaled]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_percentile' => $verbal_percentile]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_sai' => $verbal_sai]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_stanine' => $verbal_stanine]);

     $update = FinalStudentResult::where('id', $id)->update(['verbal_comprehension' => $verbal_comprehension]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_reasoning' => $verbal_reasoning]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_classification' => $verbal_classification]);

     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_raw' => $nonverbal_raw]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_scaled' => $nonverbal_scaled]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_percentile' => $nonverbal_percentile]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_sai' => $nonverbal_sai]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_stanine' => $nonverbal_stanine]);

     $update = FinalStudentResult::where('id', $id)->update(['quantitative_reasoning' => $quantitative_reasoning]);
     $update = FinalStudentResult::where('id', $id)->update(['figural_reasoning' => $figural_reasoning]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_classification' => $nonverbal_classification]);
   }

   else {

     $zero = 0;
     $NA = "NA";

     $update = FinalStudentResult::where('id', $id)->update(['total_scaled' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['total_sai' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['total_percentile' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['total_stanine' => $zero]);

     $update = FinalStudentResult::where('id', $id)->update(['total_classification' => $NA]);

     $update = FinalStudentResult::where('id', $id)->update(['verbal_scaled' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_percentile' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_sai' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['verbal_stanine' => $zero]);

     $update = FinalStudentResult::where('id', $id)->update(['verbal_classification' => $NA]);

     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_scaled' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_percentile' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_sai' => $zero]);
     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_stanine' => $zero]);

     $update = FinalStudentResult::where('id', $id)->update(['nonverbal_classification' => $NA]);

   }

   return view('student_info', compact('student_details'));
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
