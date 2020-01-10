<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentData;
use DB;

class LiveSearchController extends Controller
{
  public function students()
  {
    return view('students');
  }

  public function action(Request $request)
  {
    if($request->ajax())
   {
    $output = '';
    $query = $request->get('query');
    if($query != '')
    {
     $data = DB::table('student_datas')
       ->where('student_id', 'like', '%'.$query.'%')
       ->orWhere('name', 'like', '%'.$query.'%')
      // ->orWhere('overall_total_score', 'like', '%'.$query.'%')
       ->orWhere('birthday', 'like', '%'.$query.'%')
       //->orWhere('level', 'like', '%'.$query.'%')
       ->orderBy('name', 'asc')
       ->get();

    }
    else
    {
     $data = DB::table('student_datas')
       ->orderBy('name', 'asc')
       ->get();
    }
    $total_row = $data->count();
    if($total_row > 0)
    {
     foreach($data as $row)
     {
      $output .= '

      <tr>
       <td align="center">'.$row->student_id.'</td>
       <td>'.$row->name.'</td>
       <td align="center">'.$row->overall_total_score.'</td>
       <td align="center">'.$row->birthday.'</td>
       <td align="center">'.$row->level.'</td>
       <td><a href="studentinfo/'.$row->id.'"><button type="button" class="btn btn-primary">View</button></a></td>
      </tr>

      ';
     }
    }
    else
    {
     $output = '
     <tr>
      <td align="center" colspan="6">No Data Found</td>
     </tr>
     ';
    }
    $data = array(
     'table_data'  => $output,
     'total_data'  => $total_row
    );

    echo json_encode($data);
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
    $student_details = StudentData::find($id);
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
