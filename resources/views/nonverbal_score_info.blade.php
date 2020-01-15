@extends('components.bars')

@section('title')
<title>OLSAT | Non Verbal Score Info</title>
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
    <a class="nav-link " href="/students">
      <i class="ni ni-planet text-primary"></i> Students
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/csv">
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
  <a class="custom-breadcrumb text-dark" href="/home">Dashboard</a>
  <a>/</a>
   -->
  <a class="current-breadcrumb text-dark">> Students</a>
</div>
@endsection

@section('content')

    <h2>Student Number </h2> <p> {{$non_verbal_score_details->student_id}}</p>
    <h2>Name </h2> <p> {{$non_verbal_score_details->name}}</p>
    <h2>Non Verbal Raw Score</h2> <p>{{$non_verbal_score_details->non_verbal_raw_score}}</p>
    <h2>Non Verbal Scaled Score</h2> <p>{{$non_verbal_score_details->non_verbal_scaled_score}}</p>
    <h2>Non Verbal SAI</h2> <p>{{$non_verbal_score_details->non_verbal_sai}}</p>
    <h2>Non Verbal Percentile Rank</h2> <p>{{$non_verbal_score_details->non_verbal_percentile_rank}}</p>
    <h2>Non Verbal Stanine</h2> <p>{{$non_verbal_score_details->non_verbal_stanine}}</p>

@endsection
