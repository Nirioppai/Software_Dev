@extends('components.bars')

@section('title')
<title>OLSAT | Upload CSV</title>
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

  <a class="current-breadcrumb text-dark"><b>View Student List</b></a>
</div>
@endsection



@section('content_students')

<!-- Search form -->

<div class="col">

    <div class="row-md-8">


      </div>

      <form action="{{ route('students') }}" method="get">
        {{ csrf_field() }}

      <div class="input-group">
           <input type="text" name="search" id="search" placeholder="Search Student" value="{{$input_search}}" aria-describedby="button-addon8" class="form-control">
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
           <option value="date_of_birth" {{$orderby == "date_of_birth"? 'selected':''}}> Birthdate </option>
           <option value="grade_level" {{$orderby == "grade_level"? 'selected':''}}> Year Level </option>
         </select>

         Type:
         <select name="ordertype" id="ordertype" onchange="this.form.submit()">
           <option value="asc" {{$ordertype == "asc"? 'selected':''}}> Ascending </option>
           <option value="desc" {{$ordertype == "desc"? 'selected':''}}> Descending </option>
         </select>

      </form>


</div>

    <div class="row-md-5">


      <div class="container py-3">

<div class="row py-0">
  <div class="col-lg-12 mx-auto">
    <div class="card rounded shadow border-8">
      <div class="card-body p-4 bg-white rounded">
        <div class="table-responsive">

          <table id="example" style="width:100%" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="th-lg"><a href="">Student Number<i class="fas fa-sort ml-1"></a></i></th>
                <th class="th-lg"><a href="">Name<i class="fas fa-sort ml-1"></a></i></th>
                <!-- <th class="th-lg"><a href="">Overall Total Score<i class="fas fa-sort ml-1"></a></i></th> -->
                <th class="th-lg"><a href="">Birthdate<i class="fas fa-sort ml-1"></a></i></th>
                <th class="th-lg"><a href="">Year Level<i class="fas fa-sort ml-1"></a></i></th>
                <th class="th-lg"><a href="">Action</a></th>

              </tr>
            </thead>
            <tbody class="search_row">

              @include('pagination_data')

            </tbody>

          </table>





        </div>

        <div class="row">

          <input type="hidden" name="hidden_page" id="hidden_page" value="1" />

          <div class="col-md-4 ml--3">
              <p align="right"></p>
          </div>

          <div class="col-md-4">
             <p align="center"> <strong>Total Students:</strong> {{$count_rows}}</p>
          </div>

          <div class="col-md-4">

              <p align="left"></p>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>


      </div>



</div>


@endsection
