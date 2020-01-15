<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\student_result_total;
use DB;

class MonitoringTotalController extends Controller
{

  function monitor()
  {
     $data = DB::table('student_result_total')->orderBy('name', 'asc')->paginate(7);
     $pager = 'monitorTotal';

     return view('monitoring', compact('data'))->with('pager', $pager);
  }

  function fetch_data(Request $request)
  {
       if($request->ajax())
       {
        $query = $request->get('query');
        $query = str_replace(" ", "%", $query);
        $data = DB::table('student_result_total')
                      ->where('student_id', 'like', '%'.$query.'%')
                      ->orWhere('name', 'like', '%'.$query.'%')
                      ->orderBy('name', 'asc')
                      ->paginate(7);
        $pager = 'monitorTotal';

        return view('pagination_data', compact('data'))->with('pager', $pager)->render();
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
}
