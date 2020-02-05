@if($pager == 'student')

  @foreach($data as $row)
      <tr>
       <td align="center">{{ $row->student_id }}</td>
       <td>{{ $row->name }}</td>
       <td align="center">{{ $row->date_of_birth }}</td>
       <td align="center">{{ $row->grade_level }}</td>

       <td align="center"><a href="studentinfo/{{$row->id}}"><button type="button" class="btn btn-primary">View</button></a></td>
     </tr>

  @endforeach

      <tr>
       <td colspan="5" align="center">
         {!! $data->links() !!}
       </td>
      </tr>

@endif


@if($pager == 'monitorTotal')

  @foreach($data as $row)
      <tr>
       <td align="center">{{ $row->student_id }}</td>
       <td>{{ $row->name }}</td>
       <td align="center">{{ $row->total_raw_score }}</td>
       <td align="center">{{ $row->total_scaled_score }}</td>
       <td align="center">{{ $row->total_sai }}</td>
       <td align="center">{{ $row->total_percentile_rank }}</td>
       <td align="center">{{ $row->total_stanine }}</td>


       <td align="center"><a href="totalinfo/{{$row->id}}"><button type="button" class="btn btn-primary">View</button></a></td>
     </tr>

  @endforeach

      <tr>
       <td colspan="8" align="center">
         {!! $data->links() !!}
       </td>
      </tr>

@endif


@if($pager == 'monitorVerbal')

  @foreach($data as $row)
      <tr>
       <td align="center">{{ $row->student_id }}</td>
       <td>{{ $row->name }}</td>
       <td align="center">{{$row->verbal_raw_score}}</td>
       <td align="center">{{$row->verbal_scaled_score}}</td>
       <td align="center">{{$row->verbal_sai}}</td>
       <td align="center">{{$row->verbal_percentile_rank}}</td>
       <td align="center">{{$row->verbal_stanine}}</td>


       <td align="center"><a href="verbalinfo/{{$row->id}}"><button type="button" class="btn btn-primary">View</button></a></td>
     </tr>

  @endforeach

      <tr>
       <td colspan="8" align="center">
         {!! $data->links() !!}
       </td>
      </tr>

@endif


@if($pager == 'monitorNonVerbal')

  @foreach($data as $row)
      <tr>
       <td align="center">{{ $row->student_id }}</td>
       <td>{{ $row->name }}</td>
       <td align="center">{{$row->nonverbal_raw_score}}</td>
       <td align="center">{{$row->nonverbal_scaled_score}}</td>
       <td align="center">{{$row->nonverbal_sai}}</td>
       <td align="center">{{$row->nonverbal_percentile_rank}}</td>
       <td align="center">{{$row->nonverbal_stanine}}</td>

       <td align="center"><a href="nonverbalinfo/{{$row->id}}"><button type="button" class="btn btn-primary">View</button></a></td>
     </tr>

  @endforeach

      <tr>
       <td colspan="8" align="center">
         {!! $data->links() !!}
       </td>
      </tr>

@endif
