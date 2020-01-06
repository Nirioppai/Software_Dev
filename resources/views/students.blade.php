@extends('components.bars')

@section('title')
<title>OLSAT | Dashboard</title>
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
  <a class="custom-breadcrumb text-dark" href="/home">Dashboard</a>
  <a>/</a>
   -->
  <a class="current-breadcrumb text-dark">> Students</a>
</div>
@endsection

@section('content')
<style>

.upper_part{
  padding-left: 5rem;
  width: 1000px
}

</style>

<div class="upper_part">

  <span class="d-block p-2 bg-dark text-white">Student Corner</span>
  <!-- Default input -->
    <label for="inputDisabledEx2" class="enabled">Student Number</label>
      <input type="text" id="inputDisabledEx2" class="form-control" enabled>

  <div class="md-form input-group">
        <div class="input-group-prepend">
        <span class="input-group-text md-addon">Last, First, and Middle Name</span>
  </div>
  <input type="text" aria-label="Last name" class="form-control" placeholder="Type the Last name">
  <input type="text" aria-label="First name" class="form-control" placeholder="Type First name">
  <input type="text" aria-label="Middle name" class="form-control" placeholder="Type Middle name">
  <div class="md-form input-group">
        <div class="input-group-prepend_1">
        <span class="input-group-text md-addon">Year Level or School Year</span>
  </div>
  <input type="text" aria-label="year level" class="form-control" placeholder="Type the Year Level">
  <input type="text" aria-label="school year" class="form-control" placeholder="Type School Year">

</div>


</div>

@endsection