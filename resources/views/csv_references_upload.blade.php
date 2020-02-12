@extends('components.bars')

@section('title')
<title>OLSAT | Upload CSV - Student</title>
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

<div class="container container-responsive">
    <!-- Vertical Steppers -->
    <div class="row mt-1">
        <div class="col-md-12">

            <!-- Stepers Wrapper -->
            <ul class="stepper stepper-vertical mt--5">

              <!-- Student Data Step 1 -->
                <li @if($step == 1) class="active" @endif>

                    <a>
                        <span class="circle">1</span>
                        <span class="label">Student Data - Upload</span>
                    </a>

@if($uploader == 'student_1')
                    <div class="step-content grey lighten-3">
                        <p>First, choose a Student Data file and then upload it on the system by clicking on Submit.</p>
                    </div>

                    <!-- Form open here -->


                      <div class="input-group down ml-5 col-sm-6 ">

                          <div class="custom-file down">
                            <form method="POST" action="{{ route('uploadStudent2') }}" enctype="multipart/form-data">
                              {{ csrf_field() }}

                              <input type="file" class="custom-file-input down" id="inputGroupFile04" name="csv_file" required>
                              <label class="custom-file-label" for="inputGroupFile04">Choose file</label>

                              @if ($errors->has('csv_file'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('csv_file') }}</strong>
                                  </span>
                              @endif
                          </div>


                          <div class="input-group-append">
                              <button class="btn btn-outline-primary up" type="submit">Submit</button>
                          </div>
                      </div>


                      <div hidden class="input-group">
                          <div class="col-md-6 col-md-offset-4">
                              <div class="checkbox">
                                  <label>
                                      <input type="checkbox" name="header" checked> File contains header row?
                                  </label>
                              </div>
                          </div>
                      </div>

                    <!-- Form Close here -->
                    </form>
@endif
                </li>

                <!-- Student Data Step 2 -->

                <li @if($step == 2) class="active" @endif>

                    <a>
                        <span class="circle">2</span>
                        <span class="label">Student Data - Preview</span>
                    </a>

@if($uploader == 'student_2')

                    <div class="step-content grey lighten-3">
                        <p>Next, you can look at a preview of what is the data inside the uploaded CSV.</p>
                    </div>


                  <form method="POST" action="{{ route('uploadStudent3') }}">
                    {{ csrf_field() }}

                      <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

                      <div class="ml-5">

                          <div class="row-md-5">

                            <div class="container py-3">

                      <div class="row py-0">
                        <div class="col-lg-12 mx-auto">
                          <div class="card rounded shadow border-8">
                            <div class="card-body p-4 bg-white rounded">
                              <div class="table-responsive" style="width:900px">

                                <table id="example" style="width:100%" class="table table-striped table-bordered">
                                  <thead>
                                    @if(isset($csv_header_fields))
                                    <tr>
                                      @foreach($csv_header_fields as $csv_header_field)
                                      <th class="th-lg"><a href="">{{ $csv_header_field }}</a></th>
                                      @endforeach
                                    </tr>
                                    @endif
                                  </thead>
                                  <tbody>
                                    @foreach ($csv_data as $row)
                                              <tr>
                                              @foreach ($row as $key => $value)
                                                  <td align="center" >{{ $value }}</td>
                                              @endforeach
                                              </tr>
                                    @endforeach

                                    @foreach ($csv_data[0] as $key => $value)
                                                  <td align="center">
                                                      <select class="selectionToUpper" name="fields[{{ $key }}]">
                                                          @foreach (config('app.db_fields') as $db_field)
                                                              <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}"
                                                                  @if ($key === $db_field) selected @endif>{{ $db_field }}</option>
                                                          @endforeach
                                                      </select>
                                                  </td>
                                      @endforeach
                                  </tbody>
                                </table>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>


                            </div>

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
                    </form>



@endif
                </li>



                <!-- Student Data Step 3 -->
                <li @if($step == 3) class="active" @endif>
                    <a>
                        <span class="circle">3</span>
                        <span class="label">Student Data - Confirmation</span>
                    </a>

@if($uploader == 'student_3')
                    <div class="step-content grey lighten-3">
                        <p>Finalize <b>Student Data</b> uploading?</p>
                    </div>

                      <div class="ml-6">

                            <button type="submit" class="btn btn-secondary mt-2">
                                Cancel
                            </button>

                        <form method="POST" action="{{ route('finalizeUpload') }}">
                          {{ csrf_field() }}

                            <button type="submit" class="btn btn-primary">
                                Continue
                            </button>
                        </form>
                      </div>

                </li>
@endif

            </ul>
            <!-- /.Stepers Wrapper -->

        </div>
    </div>
    <!-- /.Vertical Steppers -->

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

@endsection
