@extends('components.bars')

@section('title')
<title>OLSAT | Student List</title>
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
  <li class="nav-item ">
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
    <a class="nav-link" href="/home/register">
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

  <a class="current-breadcrumb text-dark"><b>View Student List</b></a>
</div>
@endsection



@section('content_students')

<!-- Search form -->

      <form action="{{ route('students') }}" method="get">
        {{ csrf_field() }}

      <div class="input-group">
           <input type="text" name="search" id="search" placeholder="Search Student" value="{{$input_search}}" aria-describedby="button-addon8" class="form-control">
           <div class="input-group-append">
             <button id="button-addon8" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
           </div>
         </div>

         <br>

         <div class="form-row">
           <div class="form-group col-md-1">
                 <h5 class="text-left"><b>SHOW ROWS BY</b></h5>
               </div>
               <div class="form-group col-md-3">
                  <select class="form-control form-control-sm" name="filterby" id="filterby" onchange="this.form.submit()">
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
           </div>

           <div class="form-group col-md-1">
                 <h5 class="text-center" ><b>ORDER BY</b></h5>
               </div>
               <div class="form-group col-md-3">
                  <select class="form-control form-control-sm" name="orderby" id="orderby" onchange="this.form.submit()">
               <option value="student_name" {{$orderby == "student_name"? 'selected':''}}> Name </option>
               <option value="student_id" {{$orderby == "student_id"? 'selected':''}}> Student Number </option>
               <option value="birthday" {{$orderby == "birthday"? 'selected':''}}> Birthday </option>
               <option value="grade" {{$orderby == "grade"? 'selected':''}}> Grade </option>
               <option value="section" {{$orderby == "section"? 'selected':''}}> Section </option>
             </select>
           </div>

           <div class="form-group col-md-1">
                 <h5 class="text-center" ><b>TYPE</b></h5>
               </div>
               <div class="form-group col-md-3">
                  <select class="form-control form-control-sm" name="ordertype" id="ordertype" onchange="this.form.submit()">
               <option value="asc" {{$ordertype == "asc"? 'selected':''}}> Ascending </option>
               <option value="desc" {{$ordertype == "desc"? 'selected':''}}> Descending </option>
             </select>
           </div>
           </div>

      </form>


</div>

<table class="table align-items-center table-bordered table-striped table-flush  ">
  <thead class="thead-light">
    <tr>
      <th class="text-left text-dark">Student ID</th>
      <th class="text-left text-dark">Name</th>
      <th class="text-center text-dark">Birthdate</th>
      <th class="text-center text-dark">Grade</th>
      <th class="text-center text-dark">Section</th>
    </tr>
  </thead>

@foreach($data as $row)
  <tr>
    <td class="text-left"> <a href='view/studentinfo/{{$row->id}}'><b>{{$row->student_id}}</b></a></td>
    <td class="text-left"> <a href='view/studentinfo/{{$row->id}}'><b>{{$row->student_name}}</b></a></td>
    <td class="text-center"> <a href='view/studentinfo/{{$row->id}}'>{{$row->birthday}}</a></td>
    <td class="text-center"> <a href='view/studentinfo/{{$row->id}}'>{{$row->grade}}</a></td>
    <td class="text-center"> <a href='view/studentinfo/{{$row->id}}'>{{$row->section}}</a></td>
  </tr>
@endforeach
<tr>
 <td colspan="9" align="center">
   {!! $data  ->links() !!}
 </td>
</tr>

</table>

@endsection
