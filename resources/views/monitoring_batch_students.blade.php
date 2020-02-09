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
      <i class="fas fa-file-excel text-primary"></i> Upload CSV
    </a>
  </li>
  <li class="nav-item ">
    <a class="nav-link " href="/monitoring">
      <i class="ni ni-key-25 text-primary"></i> Monitoring
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
    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
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

  <a class="current-breadcrumb text-dark"><b>Result Monitoring</b></a>
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
    <option value="name" {{$orderby == "name"? 'selected':''}}> Name </option>
    <option value="student_id" {{$orderby == "student_id"? 'selected':''}}> Student Number </option>
  </select>

  Type:
  <select name="ordertype" id="ordertype" onchange="this.form.submit()">
    <option value="asc" {{$ordertype == "asc"? 'selected':''}}> Ascending </option>
    <option value="desc" {{$ordertype == "desc"? 'selected':''}}> Descending </option>
  </select>

</form>

<br>

<table class="table align-items-center table-bordered table-striped table-flush">
  <thead class="thead-light">
    <tr>
      <th class="text-center text-dark">Student ID</th>
      <th class="text-center text-dark">Name</th>
      <th class="text-center text-dark">Birthdate</th>
      <th class="text-center text-dark">Age in Years</th>
      <th class="text-center text-dark">Age in Months</th>
      <th class="text-center text-dark">Total Raw Score</th>
      <th class="text-center text-dark">Verbal Raw Score</th>
      <th class="text-center text-dark">Non-Verbal Raw Score</th>
      <th class="text-center text-dark">Action</th>
    </tr>
  </thead>

@foreach($batch_students as $students)

  <tr>
    <td class="text-center">{{$students->student_id}}</td>
    <td class="text-left">{{$students->name}}</td>
    <td class="text-center">{{$students->date_of_birth}}</td>
    <td class="text-center">{{$students->rounded_current_age_in_years}}</td>
    <td class="text-center">{{$students->rounded_current_age_in_months}}</td>
    <td class="text-center">{{$students->total_raw}}</td>
    <td class="text-center">{{$students->verbal_raw}}</td>
    <td class="text-center">{{$students->nonverbal_raw}}</td>
    <td align="text-center"><a href="totalinfo/{{$students->id}}"><button type="button" class="btn btn-primary">View</button></a></td>
  </tr>
@endforeach
<tr>
 <td colspan="9" align="center">
   {!! $batch_students  ->links() !!}
 </td>
</tr>


</table>
@endsection
