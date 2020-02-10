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
        <a class="nav-link active" href="/students">
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
     -->
  <a class="custom-breadcrumb text-dark" href="/students">Students</a>
  <a>/</a>

  <a class="custom-breadcrumb text-dark" href="/students/monitoring">Result Monitoring</a>
  <a>/</a>

  <a class="custom-breadcrumb text-dark" href="/students/monitoring/{{$total_score_details->batch}}">Batch Results</a>
  <a>/</a>

  <a class="current-breadcrumb text-dark"><b>Individual Result</b></a>
</div>
@endsection @section('content')

<!-- Modal -->
<form action="/students/monitoring/totalinfo/{{$total_score_details->id}}" method="POST">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}

  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="editModalLabel">Edit Student Raw Scores</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mt--3">

          <!-- <div class="form-group">
            Total
              <div class="input-group mb-4">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                  </div>
                  <input class="form-control" name="overall_total_score" value="{{$total_score_details->total_raw}}" type="number" required>
              </div>
          </div> -->
          <div class="form-group">
            Verbal
              <div class="input-group mb-4">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                  </div>
                  <input class="form-control" name="verbal_number_correct" value="{{$total_score_details->verbal_raw}}" type="number" required>
              </div>
          </div>

          <div class="form-group">
            Non-Verbal
              <div class="input-group mb-4">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                  </div>
                  <input class="form-control" name="non_verbal_number_correct" value="{{$total_score_details->nonverbal_raw}}" type="number" required>
              </div>
          </div>

        </div>
        <div class="modal-footer mt--5">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

</form>

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
                    <a href="/students/monitoring/totalinfo/{{$total_score_details->id}}/edit" class="btn btn-sm btn-default float-right ml--3" data-toggle="modal" data-target="#editModal">Edit Profile</a>
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
                        <span class="font-weight-bold">Grade Level:</span> <span class="ml-1">{{$total_score_details->grade_level}}</span>
                        <br>
                        <br>
                        <span class="font-weight-bold">Birthdate:</span> <span class="ml-1">{{$total_score_details->date_of_birth}}</span>
                        <br>
                        <span class="font-weight-bold">Age in Years:</span> <span class="ml-1">{{$total_score_details->rounded_current_age_in_years}}</span>
                        <br>
                        <span class="font-weight-bold">Age in Months:</span> <span class="ml-1">{{$total_score_details->rounded_current_age_in_months}}</span>
                        
                    </div>
                    <hr class="my-4" />
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
                        <textarea class="form-control form-control-alternative" id="exampleFormControlTextarea1" rows="3" placeholder="Write a remark about the student."></textarea>
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
            <div class="card shadow">
                <div class="card-body pt-0 pt-md-4">
                    <h2>
                        <form id="savePDF" action="{{ route('savePDF') }}" method="post">
                        @csrf
                        Student Result Report
                        <input type="hidden" name="student_no" value="{{$total_score_details->student_id}}"></input>
                        <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Save</b> a PDF copy." href="javascript:$('#savePDF').submit()"  class=" float-right"><i class="fas fa-file-pdf text-red"></i> PDF</a>
                        </form>
                    </h2>
                    Below is a preview for the Student Result Report. You can export it using the icons on the upper right. For a preview, click on the document below to expand.
                </div>


            </div>
        </div>
        <form id="viewPDF" action="{{ route('viewPDF') }}" method="post">
        @csrf
        <input  type="hidden" name="student_no" value="{{$total_score_details->student_id}}"></input>
        <a href="javascript:$('#viewPDF').submit()">
        <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Generate</b> a PDF preview." class="row-sm mt-4 picture-anchor" target="_blank">
            <img  style="width: 100%; height: 100%;" src="{{asset('./img/pdf/PDF.png')}}">
            </a>
            <div class="text-2 text-dark">Nico Del Rosario</div>
            <div class="text-3 text-dark">{{$total_score_details->grade_level}}</div>
            <div class="text-4 text-dark">Xavier School San Juan</div>
            <div class="text-5 text-dark"></div>
            <div class="text-6 text-dark">January 10, 2020</div>
            <div class="text-7 text-dark">{{$total_score_details->date_of_birth}}</div>
            <div class="text-8 text-dark">{{$total_score_details->rounded_current_age_in_years}}.{{$total_score_details->rounded_current_age_in_months}} Years old</div>
            <div class="text-9 text-dark">{{$total_score_details->verbal_raw}}</div>
            <div class="text-10 text-dark">{{$total_score_details->nonverbal_raw}}</div>
            <div class="text-11 text-dark">{{$total_score_details->total_raw}}</div>
            <div class="text-12 text-dark">{{$total_score_details->verbal_scaled}}</div>
            <div class="text-13 text-dark">{{$total_score_details->nonverbal_scaled}}</div>
            <div class="text-14 text-dark">{{$total_score_details->total_scaled}}</div>
            <div class="text-15 text-dark">{{$total_score_details->verbal_sai}}</div>
            <div class="text-16 text-dark">{{$total_score_details->nonverbal_sai}}</div>
            <div class="text-17 text-dark">{{$total_score_details->total_sai}}</div>
            <div class="text-18 text-dark">{{$total_score_details->verbal_percentile}}</div>
            <div class="text-19 text-dark">{{$total_score_details->nonverbal_percentile}}</div>
            <div class="text-20 text-dark">{{$total_score_details->total_percentile}}</div>
            <div class="text-21 text-dark">{{$total_score_details->verbal_stanine}}</div>
            <div class="text-22 text-dark">{{$total_score_details->nonverbal_stanine}}</div>
            <div class="text-23 text-dark">{{$total_score_details->total_stanine}}</div>
            <div class="text-24 text-dark"></div>
            <div class="text-25 text-dark"></div>
            <div class="text-26 text-dark"></div>
        </div>

        </form>

    </div>
</div>

@endsection
