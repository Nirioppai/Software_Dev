@extends('components.bars')

@section('title')
<title>OLSAT | Monitoring</title>
@endsection

@section('nav')
<!-- Navigation -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="/home">
      <i class="ni ni-tv-2 text-primary"></i> Dashboard
    </a>
  </li>
  <li class="nav-item active">
    <a class="nav-link active" href="/students">
      <i class="ni ni-planet text-primary"></i> Students
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="/csv">
      <i class="fas fa-file-excel text-primary"></i> OLSAT References
    </a>
  </li>
</ul>
<!-- Divider -->
<hr class="my-3">
<!-- Heading -->
<h6 class="navbar-heading text-dark">Administrator actions</h6>
<!-- Navigation -->
<ul class="navbar-nav mb-md-3">
  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-user-circle"></i> Accounts
    </a>
  </li>
</ul>
@endsection

@section('breadcrumb')
<!-- Breadcrumb -->
<div>
  <!--
  <a class="custom-breadcrumb text-dark" href="/home">Dashboard</a>
  <a>/</a>
     -->
  <a class="custom-breadcrumb text-dark" href="/students">Students</a>
  <a>/</a>

  <a class="custom-breadcrumb text-dark" href="/students/monitoring">Student Batch List</a>
  <a>/</a>

  <a class="current-breadcrumb text-dark"><b>Student Batch Results</b></a>


</div>
@endsection

@section('content')

<form url="/students/monitoring/{batch}" method="GET">
  {{ csrf_field() }}

<div class="input-group">
     <input type="text" name="search" id="search" placeholder="Search in Results" value="{{$input_search}}" aria-describedby="button-addon8" class="form-control text-dark">
     <div class="input-group-append">
       <button id="button-addon8" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
     </div>
   </div>

<br>

  Show rows by:
  <select name="filterby" id="filterby" onchange="this.form.submit()">
    <option value="5" {{$paginateby == 5? 'selected':''}}> 5 </option>
    <option value="10" {{$paginateby == 10? 'selected':''}}> 10 </option>
    <option value="25" {{$paginateby == 25? 'selected':''}}> 25 </option>
    <option value="50" {{$paginateby == 50? 'selected':''}}> 50 </option>
    <option value="75" {{$paginateby == 75? 'selected':''}}> 75 </option>
    <option value="100" {{$paginateby == 100? 'selected':''}}> 100 </option>
    <option value="250" {{$paginateby == 250? 'selected':''}}> 250 </option>
    <option value="500" {{$paginateby == 500? 'selected':''}}> 500 </option>
    <option value="1000" {{$paginateby == 1000? 'selected':''}}> 1,000 </option>
  </select>

  Order by:
  <select name="orderby" id="orderby" onchange="this.form.submit()">
    <option value="student_name" {{$orderby == "student_name"? 'selected':''}}> Name </option>
    <option value="student_id" {{$orderby == "student_id"? 'selected':''}}> Student Number </option>
    <option value="birthday" {{$orderby == "birthday"? 'selected':''}}> Birthday </option>
    <option value="total_raw" {{$orderby == "total_raw"? 'selected':''}}> Total Score </option>
    <option value="verbal_raw" {{$orderby == "verbal_raw"? 'selected':''}}> Verbal Score </option>
    <option value="nonverbal_raw" {{$orderby == "nonverbal_raw"? 'selected':''}}> Non-Verbal Score </option>
  </select>

  Type:
  <select name="ordertype" id="ordertype" onchange="this.form.submit()">
    <option value="asc" {{$ordertype == "asc"? 'selected':''}}> Ascending </option>
    <option value="desc" {{$ordertype == "desc"? 'selected':''}}> Descending </option>
  </select>

</form>

<br>

<table class="table align-items-center table-bordered table-striped table-flush  ">
  <thead class="thead-light">
    <tr>
      <th class="text-left text-dark">Student ID</th>
      <th class="text-left text-dark">Name</th>
      <th class="text-center text-dark">Birthdate</th>
      <th class="text-center text-dark">Age in Years</th>
      <th class="text-center text-dark">Age in Months</th>
    </tr>
  </thead>

@foreach($batch_students as $students)

  <tr
  @if(!\DB::table('student_batch')->where('batch', '=', $students->batch)->where('student_id', '=', $students->student_id)->pluck('nonverbal_stanine')->first())
    data-toggle="tooltip" data-html="true" title="This student is <br><b>out of scope</b>." data-placement="left"
    @endif
  
  >
    <td class="text-left"> <a href='totalinfo/{{$students->id}}'><b>
    
    {{$students->student_id}}</b></a>

    @if(!\DB::table('student_batch')->where('batch', '=', $students->batch)->where('student_id', '=', $students->student_id)->pluck('nonverbal_stanine')->first())
    &nbsp;&nbsp;&nbsp;<i class="fas fa-exclamation-triangle text-orange"></i>
    @endif
  
  </td >
    <td class="text-left"> <a href='totalinfo/{{$students->id}}'><b>{{$students->student_name}}</b></a></td>
    <td class="text-center"> <a href='totalinfo/{{$students->id}}'>{{$students->birthday}}</a></td>
    <td class="text-center"> <a href='totalinfo/{{$students->id}}'>{{$students->rounded_current_age_in_years}}</a></td>
    <td class="text-center"> <a href='totalinfo/{{$students->id}}'>{{$students->rounded_current_age_in_months}}</a></td>
  </tr>
@endforeach
<tr>
 <td colspan="9" align="center">
   {!! $batch_students  ->links() !!}
 </td>
</tr>


</table>
@endsection
