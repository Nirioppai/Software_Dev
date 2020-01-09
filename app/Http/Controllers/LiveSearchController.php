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

  public function action(Request $search_request)
  {
    if($search_request->ajax())
   {
      $output = '';
      $query = $search_request->get('query');
      if($query != '')
      {
        //  EDIT TABLE NAME HERE

         $search_data = DB::table('student_datas')
           ->where('student_id', 'like', '%'.$query.'%')
           ->orWhere('name', 'like', '%'.$query.'%')
           //->orWhere('overall_total_score', 'like', '%'.$query.'%')
           ->orWhere('birthday', 'like', '%'.$query.'%')
           //->orWhere('level', 'like', '%'.$query.'%')

           //->orWhere('YearLevel', 'like', '%'.$query.'%')
           ->orderBy('name', 'asc')
           ->get();
      }

      else
      {
        // Show All Data Available
        //  EDIT TABLE NAME HERE

         $search_data = DB::table('student_datas')
           ->orderBy('name', 'asc')
           ->get();
      }

      $total_row = $search_data->count();

      if($total_row > 0)
      {
         foreach($search_data as $search_row)
         {
            $output .= '
            <tr>
             <td>'.$search_row->student_id.'</td>
             <td>'.$search_row->name.'</td>
             <td>'.$search_row->overall_total_score.'</td>
             <td>'.$search_row->birthday.'</td>
             <td>'.$search_row->level.'</td>
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

      $search_data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($search_data);
   }
  }
}
