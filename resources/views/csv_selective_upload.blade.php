@extends('components.bars')

@section('title')
<title>OLSAT | OLSAT References</title>
@endsection

@section('nav')
<!-- Navigation -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="/home">
      <i class="ni ni-tv-2 text-primary"></i> Dashboard
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="/students">
      <i class="ni ni-planet text-primary"></i> Students
    </a>
  </li>
  <li class="nav-item active">
    <a class="nav-link active" href="/csv">
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
    <a class="current-breadcrumb text-dark">OLSAT References</a>
</div>
@endsection


@section('content')

<div class="container">
  <div class="row justify-content-center align-items-center">

    @if($scaled_display == 0)
<div class="col-sm-4 ">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/idea.png')}}" alt="Card image cap">

        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>Raw Score to Scaled Score</a></h4>
          <!-- Text -->
          <p class="card-text"><b>Upload</b> a Raw Score to Scaled Score Reference.</p>
          <br>
          &nbsp;
          <!-- Button -->
          <a href="/csv/selective-scaled/add" class="btn btn-primary">Upload</a>

        </div>

      </div>
      <!-- Card -->
    </div>
@endif

    @if($scaled_display == 1)
<div class="col-sm-4 ">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/idea.png')}}" alt="Card image cap">




        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>Raw Score to Scaled Score</a></h4>
          <!-- Text -->
          <p class="card-text"><b>Edit</b> a Raw Score to Scaled Score Reference.</p>
          <br>
          <!-- Button -->
          <a href="#" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edit</a>
          <div class="dropdown-menu dropdown-menu">
            <a class="dropdown-item" href="/csv/selective-scaled/reset" data-toggle="tooltip" data-placement="right" data-html="true" title="This will <b>Delete</b> your current reference table."><i class="fas fa-redo-alt"></i> Reset Reference</a>
            <a class="dropdown-item" href="/csv/selective-scaled/add" data-toggle="tooltip" data-placement="right" data-html="true" title="<b>Add a new set of metrics</b> in your reference table."><i class="fas fa-plus-circle"></i> Add Reference Data</a>
          </div>
        </div>


      </div>
      <!-- Card -->
    </div>
@endif

@if($stanine_display == 0)
    <div class="col-sm-4">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/analytics.png')}}" alt="Card image cap">

        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>Stanine and Percentile Rank</a></h4>
          <!-- Text -->
          <p class="card-text"><b>Upload</b> a Stanine and Percentile Rank Reference.</p>
          <!-- Button -->
          <a href="/csv/selective-stanine/add" class="btn btn-primary">Upload</a>

        </div>

      </div>
      <!-- Card -->
    </div>
@endif

@if($stanine_display == 1)
    <div class="col-sm-4">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/analytics.png')}}" alt="Card image cap">

        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>Shool Ability Index (SAI) to Percentile Rank & Stanine</a></h4>
          <!-- Text -->
          <p class="card-text"><b>Edit</b> a School Ability Index (SAI) to Percentile Rank & Stanine Reference.</p>

          <a href="#" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edit</a>
          <div class="dropdown-menu dropdown-menu">
            <a class="dropdown-item" href="/csv/selective-stanine/reset" data-toggle="tooltip" data-placement="right" data-html="true" title="This will <b>Delete</b> your current reference table."><i class="fas fa-redo-alt"></i> Reset Reference</a>
            <a class="dropdown-item" href="/csv/selective-stanine/add" data-toggle="tooltip" data-placement="right" data-html="true" title="<b>Add a new set of metrics</b> in your reference table."><i class="fas fa-plus-circle"></i> Add Reference Data</a>
          </div>

        </div>

      </div>
      <!-- Card -->
    </div>
@endif

@if($sai_display == 0)
<div class="col-sm-4">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/thought.png')}}" alt="Card image cap">

        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>Scaled Score to School Ability Index (SAI)</a></h4>
          <!-- Text -->
          <p class="card-text"><b>Upload</b> a Scaled Score to School Ability Index (SAI) Reference.</p>
          <!-- Button -->
          <a href="/csv/selective-sai/add" class="btn btn-primary">Upload</a>

        </div>

      </div>
      <!-- Card -->
    </div>
@endif

@if($sai_display == 1)
<div class="col-sm-4">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/thought.png')}}" alt="Card image cap">

        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>Scaled Score to School Ability Index (SAI)</a></h4>
          <br>
          <!-- Text -->
          <p class="card-text"><b>Edit</b> a Scaled Score to School Ability Index Reference.</p>
          <!-- Button -->



          <a href="#" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edit</a>
          <div class="dropdown-menu dropdown-menu">
            <a class="dropdown-item" href="/csv/selective-sai/reset" data-toggle="tooltip" data-placement="right" data-html="true" title="This will <b>Delete</b> your current reference table."><i class="fas fa-redo-alt"></i> Reset Reference</a>
            <a class="dropdown-item" href="/csv/selective-sai/add" data-toggle="tooltip" data-placement="right" data-html="true" title="<b>Add a new set of metrics</b> in your reference table."><i class="fas fa-plus-circle"></i> Add Reference Data</a>
          </div>

        </div>

      </div>
      <!-- Card -->
    </div>
@endif

  </div>
</div>

@if(session('success'))
    <script>
    $( document ).ready(function() {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
      toastr["success"]("CSV Import successful.", "Success ")
    });
</script>
  @endif



@endsection
