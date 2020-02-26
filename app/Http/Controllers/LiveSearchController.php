<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\student_data;
use App\FinalStudentData;
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

  // function students()
  //     {
  //      $data = DB::table('student_data')->orderBy('name', 'asc')->paginate(7);
  //      $pager = 'student';
  //      return view('students', compact('data'))->with('pager', $pager);
  //     }


  // function fetch_data(Request $request)
  //       {
  //        if($request->ajax())
  //        {
  //         $query = $request->get('query');
  //         $query = str_replace(" ", "%", $query);
  //         $data = DB::table('student_data')
  //                       ->where('student_id', 'like', '%'.$query.'%')
  //                       ->orWhere('name', 'like', '%'.$query.'%')
  //                       ->orWhere('date_of_birth', 'like', '%'.$query.'%')
  //                       ->orderBy('name', 'asc')
  //                       ->paginate(7);
  //         $pager = 'student';
  //         return view('pagination_data', compact('data'))->with('pager', $pager)->render();
  //        }
  //       }

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
   $student_details = DB::table('final_student_datas')->find($id);
   return view('student_info', compact('student_details'));
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
   $student_details->overall_total_score = $request->input('overall_total_score');
   $student_details->verbal_number_correct = $request->input('verbal_number_correct');
   $student_details->non_verbal_number_correct = $request->input('non_verbal_number_correct');

   $student_details->save();

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
