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
    <ul class="stepper stepper-vertical mt--5">

      <li class="active">

        <a>
          <span class="circle">1.1</span>
          <span class="label">Scaled Scores - Upload</span>
        </a>

        <div class="step-content grey lighten-3">
          <p>First, choose a scaled score file and then upload it on the system by clicking on Submit.</p>

        </div>

        <!-- Form open here -->
        <div class="input-group down ml-5 col-sm-6">
          <div class="custom-file down">
            <input type="file" class="custom-file-input down" id="inputGroupFile04">
            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
          </div>
          <div class="input-group-append">
            <button class="btn btn-outline-primary up" type="submit">Submit</button>
          </div>
        </div>
        <!-- Form Close here -->


      </li>

      <li class="active">

        <a>
          <span class="circle">1.2</span>
          <span class="label">Scaled Scores - Preview</span>
        </a>

        <div class="step-content grey lighten-3">
          <p>Next, you can look at a preview of what is the data inside the uploaded CSV.</p>
        </div>

        <div class="ml-5">
          <!-- Table here pliz, yung na aadjust na table ty -->

          <!-- End table -->
        </div>

        <div class="step-content grey lighten-3">
          <p>If the column data is not aligned with the column headers, feel free to rearrange using their dedicated dropdowns and assign them accordingly.</p>
          <p>You may click on Continue if everything checks out.</p>
        </div>

        <div class="ml-6">
          <button type="submit" class="btn btn-primary">
            Continue
        </button>
        </div>
      </li>

      <li class="active">
        <a>
          <span class="circle">1.3</span>
          <span class="label">Scaled Scores - Confirmation</span>
        </a>

        <div class="step-content grey lighten-3">
          <p>Proceed to <b>School Ability Index</b> uploading?</p>
        </div>

        <div class="ml-6">
          <button type="submit" class="btn btn-secondary">
            Cancel
        </button>
        <button type="submit" class="btn btn-primary">
            Continue
        </button>
        </div>
      </li>

      


      <li>
        <a>
          <span class="circle">2.1</span>
          <span class="label">School Ability Index - Upload</span>
        </a>
      </li>

       <li>
        <a>
          <span class="circle">2.2</span>
          <span class="label">School Ability Index - Preview</span>
        </a>
      </li>

      <li>
        <a>
          <span class="circle">2.3</span>
          <span class="label">School Ability Index - Confirmation</span>
        </a>
      </li>

      <li>
        <a>
          <span class="circle">3.1</span>
          <span class="label">Percentile Rank & Stanine - Upload</span>
        </a>
      </li>

       <li>
        <a>
          <span class="circle">3.2</span>
          <span class="label">Percentile Rank & Stanine - Preview</span>
        </a>
      </li>

      <li>
        <a>
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