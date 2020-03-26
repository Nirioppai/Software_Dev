@extends('components.bars')

@section('title')
<title>OLSAT | Edit Student Profile</title>
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
    <a class="nav-link" href="/csv">
      <i class="fas fa-file-excel text-primary"></i> OLSAT References
    </a>
  </li>
</ul>
<!-- Divider -->
<hr class="my-3">
<!-- Heading -->
<h6 class="navbar-heading text-dark">Administrator actions</h6>
<!-- Navigation -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="/home/register">
      <i class="fas fa-user-circle"></i> Accounts
    </a>
  </li>
</ul>

<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="/home/history">
      <i class="fas fa-history"></i> Action Log
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
  <a class="custom-breadcrumb text-dark" href="/home">Dashboard</a>
  <a>/</a>
   -->
  <a class="current-breadcrumb text-dark">> Students</a>
  <a>/</a>

  <a class="current-breadcrumb text-dark"><b>Student Info</b></a>
</div>
@endsection


@section('content')

  <form action="/students/view/studentinfo/{{$student_details->id}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

      <h1>Edit Student Details</h1>
      <br>
    <div class="form-group">
      <label>Name</label>
      <input type="text" class="form-control" name="student_name" value="{{$student_details->student_name}}" required>
    </div>
    <div class="form-group">
      <label>Student ID</label>
      <input type="text" class="form-control" name="student_id" value="{{$student_details->student_id}}" required>
    </div>
    <div class="form-group">
      <label>Grade</label>
      <input type="number" class="form-control" name="grade" value="{{$student_details->grade}}" required>
    </div>
    <div class="form-group">
      <label>Section</label>
      <input type="text" class="form-control" name="section" value="{{$student_details->section}}" required>
    </div>
    <div class="form-group">
      <label>Birthday</label>
      <input type="date" class="form-control" name="birthday" value="{{$student_details->birthday}}" required>
    </div>
    <div class="form-group">
      <label>Exam Date</label>
      <input type="date" class="form-control" name="exam_date" value="{{$student_details->exam_date}}" required>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

@endsection
