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
<table class="table align-items-center table-bordered table-striped table-flush">
  <thead class="thead-light">
    <tr>
      <th class="text-left text-dark">Student ID</th>
      <th class="text-left text-dark">Name</th>
      <th class="text-left text-dark">Action</th>
    </tr>
  </thead>

@foreach($batch_students as $students)

  <tr>
    <td class="text-left">{{$students->student_id}}</td>
    <td class="text-left">{{$students->name}}</td>
    <td class="text-left">{{$students->name}}</td>
    <td align="text-left"><a href="totalinfo/{{$students->id}}"><button type="button" class="btn btn-primary">View</button></a></td>


  </tr>
    @endforeach

</table>
@endsection