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
  <a class="custom-breadcrumb text-dark" href="/home">Dashboard</a>
  <a>/</a>
   -->
  <a class="current-breadcrumb text-dark">> Upload CSV</a>
</div>
@endsection

@section('content')




<div class="container">

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
  <div class="row justify-content-center align-items-center">
    <div class="col-sm-4 ">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/Slanted-Gradient1.png')}}" alt="Card image cap">




        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>Student Data</a></h4>
          <!-- Text -->
          <p class="card-text">Upload Student Data to monitor their IQ statistics.</p>
          <!-- Button -->
          <a href="/csv/students/1" class="btn btn-primary">Next</a>

        </div>

      </div>
      <!-- Card -->
    </div>
    <div class="col-sm-4">
      <!-- Card -->
      <div class="card hoverable">

        <!-- Card image -->
        <img class="card-img-top" src="{{asset('./img/brand/olsat_tables.png')}}" alt="Card image cap">

        <!-- Card content -->
        <div class="card-body">

          <!-- Title -->
          <h4 class="card-title"><a>OLSAT Tables</a></h4>
          <!-- Text -->
          <p class="card-text">Update the OLSAT references. <br>&nbsp;</p>
          <!-- Button -->
          <a href="/csv/references" class="btn btn-primary">Next</a>

        </div>

      </div>
      <!-- Card -->
    </div>
  </div>
</div>

@endsection
