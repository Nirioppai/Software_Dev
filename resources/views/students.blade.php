@extends('components.bars')

@section('title')
<title>OLSAT | Students</title>
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
  <a class="current-breadcrumb text-dark">Students</a>
</div>
@endsection

@section('content')
<div class="container">

  <div class="row justify-content-center align-items-center">
      <div class="col-sm-4 ">
        <!-- Card -->
        <div class="card hoverable">

          <!-- Card image -->
          <img class="card-img-top" src="http://localhost:8000/./img/brand/Slanted-Gradient1.png" alt="Card image cap">




          <!-- Card content -->
          <div class="card-body">

            <!-- Title -->
            <h4 class="card-title"><a>Upload Student Data</a></h4>
            <!-- Text -->
            <p class="card-text">Upload Student Data to monitor their IQ statistics.</p>
            <!-- Button -->
            <a href="/students/upload/1" class="btn btn-primary">Next</a>

          </div>

        </div>
        <!-- Card -->
      </div>

      <div class="col-sm-4 ">
        <!-- Card -->
        <div class="card hoverable">

          <!-- Card image -->
          <img class="card-img-top" src="http://localhost:8000/./img/brand/Slanted-Gradient1.png" alt="Card image cap">




          <!-- Card content -->
          <div class="card-body">

            <!-- Title -->
            <h4 class="card-title"><a>View Student List</a></h4>
            <!-- Text -->
            <p class="card-text">Take a look at the contents of your student CSV Uploads.</p>
            <!-- Button -->
            <a href="/students/view" class="btn btn-primary">Next</a>

          </div>

        </div>
        <!-- Card -->
      </div>

      <div class="col-sm-4">
        <!-- Card -->
        <div class="card hoverable">

          <!-- Card image -->
          <img class="card-img-top" src="http://localhost:8000/./img/brand/olsat_tables.png" alt="Card image cap">

          <!-- Card content -->
          <div class="card-body">

            <!-- Title -->
            <h4 class="card-title"><a>Student Results</a></h4>
            <!-- Text -->
            <p class="card-text">Check the <b>computed</b> OLSAT Results of your students.</p>
            <!-- Button -->
            <a href="/students/monitoring" class="btn btn-primary">Next</a>

          </div>

        </div>
        <!-- Card -->
      </div>
    </div>

    @if(session('success'))
  <script>
      $(document).ready(function() {
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

</div>


@endsection
