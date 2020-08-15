@extends('components.bars')

@section('title')
<title>OLSAT | Student Info</title>
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


<div class="container">
  <div class="row mt-4">
  <div class="col">
  <div class="card">
  <div class="card-header">
    <h2>Student Information</h2>
  </div>
  <div class="card-body">
  <div class="row">
    <div class="col-sm">
      <h2>
        Personal Details
      </h2>
      <b>Student no:</b> {{$student_details->student_id}}<br>
      <b>Grade:</b> {{$student_details->grade}}<br>
      <b>Section:</b> {{$student_details->section}}<br>
      <b>Birthday:</b> {{$student_details->birthday}}<br>
      <b>Exam Date:</b> {{$student_details->exam_date}}<br>
      <div data-toggle="tooltip" data-placement="left" title="Age in years and month">    
      <b>Current age:</b> {{$student_details->rounded_current_age_in_years}}.{{$student_details->rounded_current_age_in_months}}<br>  
      </div>
      <h2 class="mt-2"> Scores </h2> 
      <b>Overall total score:</b> {{$student_details->total_score}}<br>
      <b>Verbal raw score:</b> {{$student_details->verbal_total_score}}<br>
      <b>Non-verbal raw score:</b> {{$student_details->non_verbal_total_score}}<br>
    </div>
    <div class="col-sm">
      
      <h2>Other details</h2>
      <b>Verbal comprehension:</b> {{$student_details->verbal_comprehension}}<br>
      <b>Verbal reasoning:</b> {{$student_details->verbal_reasoning}}<br>
      <b>Quantitative reasoning:</b> {{$student_details->quantitative_reasoning}}<br>
      <b>Figural reasoning:</b> {{$student_details->figural_reasoning}}<br>
      <b>Exam batch number:</b> {{$student_details->batch}}
    </div>
  </div>
  
  </div>
</div>
  </div>
  </div>
</div>



@endsection