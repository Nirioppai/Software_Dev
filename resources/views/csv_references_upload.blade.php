@extends('components.bars')

@section('title')
<title>OLSAT | Upload CSV - Reference</title>
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
  <div class="row justify-content-center align-items-center">
    <!-- Vertical Steppers -->
    <div class="row mt--5">
      <div class="col-md-12">
        @if($uploader == 'scaled_scores')
        <!-- Stepers Wrapper -->
        <ul class="stepper stepper-vertical">

          <!-- First Step -->
          <li @if($step == 1) class="active" @endif>
            <a href="#!">
              <span class="circle">1</span>
              <span class="label">Upload CSV Scaled Scores</span>
            </a>

            @if($step == 1)
            <!-- Section Description -->
            <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <!-- {!! Form::open(['url' => '/csv/references/scaledscores/2']) !!}
                @csrf
                <div class="input-group down col-sm-6">
                    <div class="custom-file down">
                      <input type="file" class="custom-file-input down" id="inputGroupFile04">
                      <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary up" type="submit">Submit</button>
                    </div>
                  </div>
                {!! Form::close() !!} -->
            </div>
              <!-- Native Form Scaled Score-->
              <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading"><!--CSV Import--></div>

                            <div class="panel-body">
                                <form class="form-horizontal" method="POST" action="{{ route('uploadScaledScore2') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                        <label for="csv_file" class="col-md-4 control-label"><!--CSV file to import--></label>

                                        <div class="col-md-6">
                                            <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                                            @if ($errors->has('csv_file'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('csv_file') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div hidden class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="header" checked> File contains header row?
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
          </li>

          <!-- Second Step -->
          <li @if($step == 2)class="active" @endif>

            <!--Section Title -->
            <a href="#!">
              <span class="circle">2</span>
              <span class="label">CSV Preview</span>
            </a>

            @if($step == 2)
            <!-- Section Description -->
            <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <!-- <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
                {!! Form::open(['url' => '/csv/references/scaledscores/3']) !!}
                @csrf

                      <button class="btn btn-outline-primary up" type="submit">Submit</button>

                {!! Form::close() !!} -->
            </div>

            <!-- Display Preview Scaled Score-->
              <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">CSV Import</div>

                            <div class="panel-body">
                                <form class="form-horizontal" method="POST" action="{{ route('uploadScaledScore3') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

                                    <table class="table">
                                        @if (isset($csv_header_fields))
                                        <tr>
                                            @foreach ($csv_header_fields as $csv_header_field)
                                                <th>{{ $csv_header_field }}</th>
                                            @endforeach
                                        </tr>
                                        @endif
                                        @foreach ($csv_data as $row)
                                            <tr>
                                            @foreach ($row as $key => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @foreach ($csv_data[0] as $key => $value)
                                                <td>
                                                    <select name="fields[{{ $key }}]">
                                                        @foreach (config('app.db_raw_to_scaleds') as $db_raw_to_scaled)
                                                            <option value="{{ (\Request::has('header')) ? $db_raw_to_scaled : $loop->index }}"
                                                                @if ($key === $db_raw_to_scaled) selected @endif>{{ $db_raw_to_scaled }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>

                                    <button type="submit" class="btn btn-primary">
                                        Confirm
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
          </li>

          <!-- Third Step -->
          <!-- <li @if($step==3) class="active" @endif>
            <a href="#!">
              <span class="circle">3</span>
              <span class="label">Confirmation</span>
            </a>

            @if($step == 3) -->
            <!-- Section Description -->
            <!-- <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse cupiditate voluptate facere
                iusto
                quaerat
                vitae excepturi, accusantium ut aliquam repellat atque nesciunt nostrum similique. Inventore
                nostrum
                ut,
                nobis porro sapiente.</p>

                <div class="container">
                  <div class="row">
                    <div class="col-sm-2">
                      <button class="btn btn-outline-primary up" onclick="location.href='/csv/references/scaledscores/1';" type="submit">Cancel</button>
                    </div>
                    <div class="col-sm-2">
                      {!! Form::open(['url' => '/csv/references/scaledscores/3/submit']) !!}
                      @csrf
                      <button class="btn btn-outline-primary up" type="submit">Confirm</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
            </div>
            @endif
          </li> -->

        </ul>
        <!-- /.Stepers Wrapper -->
        @endif

        @if($uploader == 'sai')
        <!-- Stepers Wrapper -->
        <ul class="stepper stepper-vertical">

          <!-- First Step -->
          <li @if($step == 1) class="active" @endif>
            <a href="#!">
              <span class="circle">1</span>
              <span class="label">Upload CSV School Ability Index (SAI)</span>
            </a>

            @if($step == 1)
            <!-- Section Description -->
            <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <!-- {!! Form::open(['url' => '/csv/references/percentile_stanine/2']) !!}
                @csrf
                <div class="input-group down col-sm-6">
                    <div class="custom-file down">
                      <input type="file" class="custom-file-input down" id="inputGroupFile04">
                      <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary up" type="submit">Submit</button>
                    </div>
                  </div>
                {!! Form::close() !!} -->
            </div>
            <!-- Native Form SAI -->
              <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading"><!--CSV Import--></div>

                            <div class="panel-body">
                                <form class="form-horizontal" method="POST" action="{{ route('uploadSAI2') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                        <label for="csv_file" class="col-md-4 control-label"><!--CSV file to import--></label>

                                        <div class="col-md-6">
                                            <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                                            @if ($errors->has('csv_file'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('csv_file') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div hidden class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="header" checked> File contains header row?
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
          </li>

          <!-- Second Step -->
          <li @if($step == 2)class="active" @endif>

            <!--Section Title -->
            <a href="#!">
              <span class="circle">2</span>
              <span class="label">CSV Preview</span>
            </a>

            @if($step == 2)
            <!-- Section Description -->
            <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <!-- <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
                {!! Form::open(['url' => '/csv/references/percentile_stanine/3']) !!}
                @csrf

                      <button class="btn btn-outline-primary up" type="submit">Submit</button>

                {!! Form::close() !!} -->
            </div>

            <!-- Display Preview SAI-->
              <div class="container" >
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">CSV Import</div>

                            <div class="panel-body">
                                <form class="form-horizontal" method="POST" action="{{ route('uploadSAI3') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

                                    <table class="table">
                                        @if (isset($csv_header_fields))
                                        <tr>
                                            @foreach ($csv_header_fields as $csv_header_field)
                                                <th>{{ $csv_header_field }}</th>
                                            @endforeach
                                        </tr>
                                        @endif
                                        @foreach ($csv_data as $row)
                                            <tr>
                                            @foreach ($row as $key => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @foreach ($csv_data[0] as $key => $value)
                                                <td>
                                                    <select name="fields[{{ $key }}]">
                                                        @foreach (config('app.db_scaled_to_sais') as $db_scaled_to_sai)
                                                            <option value="{{ (\Request::has('header')) ? $db_scaled_to_sai : $loop->index }}"
                                                                @if ($key === $db_scaled_to_sai) selected @endif>{{ $db_scaled_to_sai }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>

                                    <button type="submit" class="btn btn-primary">
                                        Confirm
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
          </li>

          <!-- Third Step -->
          <!-- <li @if($step==3) class="active" @endif>
            <a href="#!">
              <span class="circle">3</span>
              <span class="label">Confirmation</span>
            </a>

            @if($step == 3) -->
            <!-- Section Description -->
            <!-- <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse cupiditate voluptate facere
                iusto
                quaerat
                vitae excepturi, accusantium ut aliquam repellat atque nesciunt nostrum similique. Inventore
                nostrum
                ut,
                nobis porro sapiente.</p>

                <div class="container">
                  <div class="row">
                    <div class="col-sm-2">
                      <button class="btn btn-outline-primary up" onclick="location.href='/csv/references/percentile_stanine/1';" type="submit">Cancel</button>
                    </div>
                    <div class="col-sm-2">
                      {!! Form::open(['url' => '/csv/references/percentile_stanine/3/submit']) !!}
                      @csrf
                      <button class="btn btn-outline-primary up" type="submit">Confirm</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
            </div>
            @endif
          </li> -->

        </ul>
        <!-- /.Stepers Wrapper -->
        @endif

        @if($uploader == 'percentile_stanine')
        <!-- Stepers Wrapper -->
        <ul class="stepper stepper-vertical">

          <!-- First Step -->
          <li @if($step == 1) class="active" @endif>
            <a href="#!">
              <span class="circle">1</span>
              <span class="label">Upload CSV Percentile Rank and Stanine</span>
            </a>

            @if($step == 1)
            <!-- Section Description -->
            <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <!-- {!! Form::open(['url' => '/csv/references/percentile_stanine/2']) !!}
                @csrf
                <div class="input-group down col-sm-6">
                    <div class="custom-file down">
                      <input type="file" class="custom-file-input down" id="inputGroupFile04">
                      <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary up" type="submit">Submit</button>
                    </div>
                  </div>
                {!! Form::close() !!} -->
            </div>

            <!-- Native Form Percentile Stanine -->
              <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading"><!--CSV Import--></div>

                            <div class="panel-body">
                                <form class="form-horizontal" method="POST" action="{{ route('uploadStanine2') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                        <label for="csv_file" class="col-md-4 control-label"><!--CSV file to import--></label>

                                        <div class="col-md-6">
                                            <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                                            @if ($errors->has('csv_file'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('csv_file') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div hidden class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="header" checked> File contains header row?
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
          </li>

          <!-- Second Step -->
          <li @if($step == 2)class="active" @endif>

            <!--Section Title -->
            <a href="#!">
              <span class="circle">2</span>
              <span class="label">CSV Preview</span>
            </a>

            @if($step == 2)
            <!-- Section Description -->
            <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <!-- <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
                {!! Form::open(['url' => '/csv/references/percentile_stanine/3']) !!}
                @csrf

                      <button class="btn btn-outline-primary up" type="submit">Submit</button>

                {!! Form::close() !!} -->
            </div>

            <!-- Display Preview Percentile Stanine-->
              <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">CSV Import</div>

                            <div class="panel-body">
                                <form class="form-horizontal" method="POST" action="{{ route('uploadStanine3') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

                                    <table class="table">
                                        @if (isset($csv_header_fields))
                                        <tr>
                                            @foreach ($csv_header_fields as $csv_header_field)
                                                <th>{{ $csv_header_field }}</th>
                                            @endforeach
                                        </tr>
                                        @endif
                                        @foreach ($csv_data as $row)
                                            <tr>
                                            @foreach ($row as $key => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @foreach ($csv_data[0] as $key => $value)
                                                <td>
                                                    <select name="fields[{{ $key }}]">
                                                        @foreach (config('app.db_sai_to_percentile_ranks') as $db_sai_to_percentile_rank)
                                                            <option value="{{ (\Request::has('header')) ? $db_sai_to_percentile_rank : $loop->index }}"
                                                                @if ($key === $db_sai_to_percentile_rank) selected @endif>{{ $db_sai_to_percentile_rank }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>

                                    <button type="submit" class="btn btn-primary">
                                        Confirm
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
          </li>

          <!-- Third Step -->
          <!-- <li @if($step==3) class="active" @endif>
            <a href="#!">
              <span class="circle">3</span>
              <span class="label">Confirmation</span>
            </a>

            @if($step == 3) -->
            <!-- Section Description -->
            <!-- <div class="step-content grey lighten-3">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse cupiditate voluptate facere
                iusto
                quaerat
                vitae excepturi, accusantium ut aliquam repellat atque nesciunt nostrum similique. Inventore
                nostrum
                ut,
                nobis porro sapiente.</p>

                <div class="container">
                  <div class="row">
                    <div class="col-sm-2">
                      <button class="btn btn-outline-primary up" onclick="location.href='/csv/references/percentile_stanine/1';" type="submit">Cancel</button>
                    </div>
                    <div class="col-sm-2">
                      {!! Form::open(['url' => '/csv/references/percentile_stanine/3/submit']) !!}
                      @csrf
                      <button class="btn btn-outline-primary up" type="submit">Confirm</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
            </div>
            @endif
          </li> -->

        </ul>
        <!-- /.Stepers Wrapper -->
        @endif
      </div>
    </div>
  </div>
</div>


@endsection
