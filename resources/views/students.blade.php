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

@section('content_students')

<!-- Search form -->

<div class="col">

    <div class="row-md-8">

      <!-- just added id and name here -->
      <input type="text" name="search" id="search" class="form-control mt-0" type="text" placeholder="Search Student" aria-label="Search">

    </div>

    <div class="row-md-8">


        <div class="card card-cascade narrower mt-4 ">

          <!--Card image-->
          <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-5 mb-3 d-flex justify-content-between align-items-center">



            <a href="" class="white-text mx-3 position-center">Student's Profile</a>



          </div>
          <!--/Card image-->

          <div class="px-4">

            <!-- added table-responsive class -->
            <div class="table-wrapper" class="table-responsive">

              <!-- to show total queries -->
              <h3 align="center">Total Data : <span id="total_records"></span></h3>

              <!--Table-->
              <table class="table table-hover mb-0">

                <!--Table head-->
                <thead>
                  <tr>

                    <th class="th-lg">
                      <a href="">Student Number
                        <i class="fas fa-sort ml-1"></i>
                      </a>
                    </th>
                    <th class="th-lg">
                      <a href="">Name
                        <i class="fas fa-sort ml-1"></i>
                      </a>
                    </th>
                    <th class="th-lg">
                      <a href="">Overall Total Score
                        <i class="fas fa-sort ml-1"></i>
                      </a>
                    </th>
                    <th class="th-lg">
                      <a href="">Birthday
                        <i class="fas fa-sort ml-1"></i>
                      </a>
                    </th>
                    <th class="th-lg">
                      <a href="">Level
                        <i class="fas fa-sort ml-1"></i>
                      </a>
                    </th>

                  </tr>
                </thead>
                <!--Table head-->

                <!--Table body-->

                <!-- left tbody empty for table response -->
                <tbody class="searchrows">

                   <!-- <tr class="bs-table-row">
                      <a class="bs-row-link" href="">
                      <td>2018-02454</td>
                      <td>Recierdo</td>
                      <td>Rafael John</td>
                      <td>12-08-1999</td>
                      <td>2019-2020</td>
                        </a>
                 </tr>
                 </tbody>
                 <tr class="bs-table-row">
                    <a class="bs-row-link" href="">
                     <td>2018-03453</td>
                     <td>Del Rosario</td>
                     <td>Nico</td>
                     <td>12-08-1999</td>
                     <td>2019-2020</td>
                </tr>
                <tr class="bs-table-row">
                   <a class="bs-row-link" href="">
                    <td>2018-05673</td>
                    <td>Pinggoy</td>
                    <td>Dennise</td>
                    <td>12-08-1999</td>
                    <td>2019-2020</td>
               </tr>
               </a> -->




                </tbody>

                <!--Table body-->
              </table>
              <!--Table-->
            </div>

          </div>

        </div>
      </div>



</div>


@endsection