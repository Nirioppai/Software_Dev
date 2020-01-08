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
        //  EDIT TABLE NAME HERE

         $data = DB::table('student_datas')
           ->where('StudentNumber', 'like', '%'.$query.'%')
           ->orWhere('LastName', 'like', '%'.$query.'%')
           ->orWhere('FirstName', 'like', '%'.$query.'%')
           ->orWhere('Birthdate', 'like', '%'.$query.'%')

           //->orWhere('YearLevel', 'like', '%'.$query.'%')
           ->orderBy('id', 'desc')
           ->get();
      }

      else
      {
        // Show All Data Available
        //  EDIT TABLE NAME HERE

         $data = DB::table('student_datas')
           ->orderBy('id', 'asc')
           ->get();
      }

      $total_row = $data->count();

      if($total_row > 0)
      {
         foreach($data as $row)
         {
            $output .= '
            <tr>
             <td>'.$row->StudentNumber.'</td>
             <td>'.$row->LastName.'</td>
             <td>'.$row->FirstName.'</td>
             <td>'.$row->Birthdate.'</td>
             <td>'.$row->YearLevel.'</td>
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
