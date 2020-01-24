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
  <a class="current-breadcrumb text-dark">> Upload CSV</a>
</div>
@endsection

@section('content')

<div class="container">
<!-- Vertical Steppers -->
<div class="row mt-1">
  <div class="col-md-12">

    <!-- Stepers Wrapper -->
    <ul class="stepper stepper-vertical">

      <li class="completed">
        <a href="#!">
          <span class="circle">1.1</span>
          <span class="label">Scaled Scores - Upload</span>
        </a>
      </li>

      <li class="active">

        <a href="#!">
          <span class="circle">1.2</span>
          <span class="label">Scaled Scores - Preview</span>
        </a>

        <div class="step-content grey lighten-3">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse cupiditate voluptate facere
            iusto
            quaerat
            vitae excepturi, accusantium ut aliquam repellat atque nesciunt nostrum similique. Inventore
            nostrum
            ut,
            nobis porro sapiente.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore error excepturi veniam nemo
            repellendus, distinctio soluta vitae at sit saepe. Optio eaque quia excepturi adipisci pariatur
            totam,
            atque odit fugiat.</p>
          <p>Deserunt voluptatem illum quae nisi soluta eum perferendis nesciunt asperiores tempore saepe
            reiciendis,
            vero quod a dolor corporis natus qui magni quas fuga rem excepturi laboriosam. Quisquam
            expedita ab
            fugiat.</p>
        </div>
      </li>

      <li class="active">
        <a href="#!">
          <span class="circle">1.3</span>
          <span class="label">School Ability Index - Confirmation</span>
        </a>
      </li>


      <li>
        <a href="#!">
          <span class="circle">2.1</span>
          <span class="label">School Ability Index - Upload</span>
        </a>
      </li>

       <li>
        <a href="#!">
          <span class="circle">2.2</span>
          <span class="label">School Ability Index - Preview</span>
        </a>
      </li>

      <li>
        <a href="#!">
          <span class="circle">2.3</span>
          <span class="label">School Ability Index - Confirmation</span>
        </a>
      </li>

      <li>
        <a href="#!">
          <span class="circle">3.1</span>
          <span class="label">Percentile Rank & Stanine - Upload</span>
        </a>
      </li>

       <li>
        <a href="#!">
          <span class="circle">3.2</span>
          <span class="label">Percentile Rank & Stanine - Preview</span>
        </a>
      </li>

      <li>
        <a href="#!">
          <span class="circle">3.3</span>
          <span class="label">Percentile Rank & Stanine - Confirmation</span>
        </a>
      </li>

    </ul>
    <!-- /.Stepers Wrapper -->

  </div>
</div>

<!-- Steppers Navigation -->
<div class="row mt-1">
  <div class="col-md-12 text-right">
    <button class="btn btn-flat btn-sm">Cancel</button>
    <button class="btn btn-primary btn-sm">Next</button>
  </div>
</div>
<!-- /.Vertical Steppers -->
  
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
