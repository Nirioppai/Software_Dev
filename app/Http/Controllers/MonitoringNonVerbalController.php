<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\student_result_nonverbal;
use DB;


class MonitoringNonVerbalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function monitoring_nonverbal(Request $req)
    {
      $pager = 'monitorNonVerbal';

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
          $data = DB::table('student_result_non_verbal')->orderBy($orderby, $ordertype)->paginate($paginateby);
          $count_rows = DB::table('student_result_non_verbal')->count();
          $data->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);
          $current_page = $data->currentPage();

          return view ('monitoring_nonverbal', compact('data'))->with('pager' , $pager)->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype)->with('count_rows', $count_rows)->with('current_page', $current_page);
      }
      else
      {
          $paginateby = $req->filterby;
          $input_search = $req->search;
          $data = DB::table('student_result_non_verbal')->where('student_id', 'like', ''.$req->search.'%')
                ->orWhere('name', 'like', ''.$req->search.'%')
                ->orderBy($orderby, $ordertype)
                ->paginate($paginateby);

          $search_result_count = DB::table('student_result_non_verbal')->where('student_id', 'like', ''.$req->search.'%')
                ->orWhere('name', 'like', ''.$req->search.'%');

          $count_rows = $search_result_count->count();
          $data->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);
          $current_page = $data->currentPage();


          return view ('monitoring_nonverbal', compact('data'))->with('pager' , $pager)->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype)->with('count_rows', $count_rows)->with('current_page', $current_page);
        }
      }

  // function monitoring_nonverbal()
  // {
  //    $data = DB::table('student_result_nonverbal')->orderBy('name', 'asc')->paginate(7);
  //    $pager = 'monitorNonVerbal';
  //
  //    return view('monitoring_nonverbal', compact('data'))->with('pager', $pager);
  // }
  //
  // function fetch_data(Request $request)
  // {
  //      if($request->ajax())
  //      {
  //       $query = $request->get('query');
  //       $query = str_replace(" ", "%", $query);
  //       $data = DB::table('student_result_nonverbal')
  //                     ->where('student_id', 'like', '%'.$query.'%')
  //                     ->orWhere('name', 'like', '%'.$query.'%')
  //                     ->orderBy('name', 'asc')
  //                     ->paginate(7);
  //       $pager = 'monitorNonVerbal';
  //
  //       return view('pagination_data', compact('data'))->with('pager', $pager)->render();
  //       }
  // }

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
      $non_verbal_score_details = DB::table('student_result_nonverbal')->find($id);
      return view('nonverbal_score_info', compact('non_verbal_score_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
