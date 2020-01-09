<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
       <td>'.$row->student_id.'</td>
       <td>'.$row->name.'</td>
       <td>'.$row->overall_total_score.'</td>
       <td>'.$row->birthday.'</td>
       <td>'.$row->level.'</td>
      </tr>
      ';
     }
    }
    else
    {
     $output = '
     <tr>
      <td align="center" colspan="5">No Data Found</td>
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
}
