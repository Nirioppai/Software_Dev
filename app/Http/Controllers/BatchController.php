<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BatchList;
use App\FinalStudentData;
use App\FinalStudentResult;
use DB;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function monitor($batch, Request $req)
    {

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
          $batch_students = DB::table('final_student_results')
            ->where('batch',  $batch)
            ->orderBy($orderby, $ordertype)
            ->paginate($paginateby);
          // $batch_students->appends($req->only('search'));
          $batch_students->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);

          return view('monitoring_batch_students', compact('batch_students'))->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype);
      }

      else {
          $input_search = $req->search;
          $batch_students = DB::table('final_student_results')
            ->where('batch',  $batch)
            ->where('name', 'like', ''.$req->search.'%')
            ->orWhere('date_of_birth', 'like', ''.$req->search.'%')
            ->orWhere('student_id', 'like', ''.$req->search.'%')
            ->orderBy($orderby, $ordertype)
            ->paginate($paginateby);
          // $batch_students->appends($req->only('search'));
          $batch_students->appends(['search' => $req->search, 'filterby' => $req->filterby, 'orderby' => $req->orderby, 'ordertype' => $req->ordertype]);

          return view('monitoring_batch_students', compact('batch_students'))->with('input_search', $input_search)->with('paginateby', $paginateby)->with('orderby', $orderby)->with('ordertype', $ordertype);
      }

        // $batch_students = DB::table('final_student_results')->where('batch',  $batch)->get();
        // return view('monitoring_batch_students')->with('batch_students', $batch_students)->with('req', $req);
    }

    public function index()
    {
        $batchList = DB::table('batch_list')->get();
        return view('monitoring_batch')->with('batchList', $batchList);
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
        //
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


    public function deleteBatch($batch)
    {

        $deleteBatch = FinalStudentData::where('batch', $batch)->delete();
        $deleteBatch = FinalStudentResult::where('batch', $batch)->delete();

        

        return redirect('/students/monitoring');

    }
}
