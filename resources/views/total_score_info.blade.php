@extends('components.bars') @section('title')
<title>OLSAT | Total Score Info</title>
@endsection @section('nav')
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
@endsection @section('breadcrumb')
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
@endsection @section('content')

<div class="row mt-4">
    <div class="col-xl-4  mb-5 mb-xl-0">
        <div class="card card-profile shadow">
            <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">

                        <img src="{{asset('./img/brand/student-img.png')}}" class="rounded-circle">

                    </div>
                </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-sm btn-default float-right ml--3">Edit Profile</a>
                </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
                <div class="text-center mt-5">
                    <h1>
                        {{$total_score_details->name}}
                    </h1>
                    <hr class="my-3">
                    <div class="text-left">
                        <h2>
                            Personal Details
                        </h2>
                        <span class="font-weight-bold">Student No:</span> <span class="ml-1">{{$total_score_details->student_id}}</span>
                        <br>
                        <span class="font-weight-bold">Birthdate:</span> <span class="ml-3">08-06-1999</span>
                    </div>
                    <hr class="my-4" />
                    <p>Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.</p>
                    <a href="#">Show more</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="row-sm">
            <div class="card shadow">
                <div class="card-body pt-0 pt-md-4">
                    <h2>
                        Remarks
                    </h2>
                    <form>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Write a remark about the student."></textarea>
                    </form>

                    <div class="row">

                      <div class="col">  </div>
                      <div class="col">  </div>
                      <div class="col">  </div>
                      <div class="col">  </div>
                      <div class="col-sm mt-2"> </div>
                      <div class="col-sm mt-2">

                              <a href=""  class="btn btn-primary btn-rounded">Edit</a>
                      </div>

                    </div>

                </div>


            </div>
        </div>
        <div class="row-sm mt-4">
            <img style="width: 100%; height: 100%;" src="{{asset('./img/pdf/PDF.png')}}">
        </div>
    </div>
</div>

@endsection
