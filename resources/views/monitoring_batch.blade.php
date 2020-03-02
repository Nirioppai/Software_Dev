@extends('components.bars')

@section('title')
<title>OLSAT | Monitoring</title>
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
    <a class="nav-link" href="/home/register">
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
     -->
  <a class="custom-breadcrumb text-dark" href="/students">Students</a>
  <a>/</a>

  <a class="current-breadcrumb text-dark"><b>Student Batch List</b></a>
</div>
@endsection

@section('content')
<table class="table align-items-center table-bordered table-striped table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-left text-dark">Batch</th>
                          <th class="text-left text-dark">Batch Upload Date</th>
                          <th class="text-left text-dark">Status</th>
                          <th class="text-left text-dark">Action</th>
                        </tr>
                      </thead>

                    @foreach($batchList as $batch)

                      <tr>
                        <td class="text-left"><a href='monitoring/{{$batch->batch}}'><b>Student Result Batch {{$batch->batch}}</b></a></td>
                        <td class="text-left">{{$batch->created_at}}</td>
                      <td class="text-left">
                        @if(DB::table('student_batch')->where('batch', '=', $batch->batch)->where('nonverbal_stanine', '=', 0)->count() == 0)
                          <i class="fas fa-check-circle text-green"></i>&nbsp;&nbsp;&nbsp;<b>Normal Results</b>
                        @endif
                        
                        @if(DB::table('student_batch')->where('batch', '=', $batch->batch)->where('nonverbal_stanine', '=', 0)->count() != 0)
                          <i class="fas fa-exclamation-triangle text-orange"></i>&nbsp;&nbsp;&nbsp;<b>{{\DB::table('student_batch')->where('batch', '=', $batch->batch)->where('nonverbal_stanine', '=', 0)->count()}} Students out of scope</b>
                        @endif
                      </td>
                        <td class="text-left">



                          <a  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="icon icon-shape bg-primary
                                     text-white rounded-circle shadow">
                            <i class="fas fa-cogs"></i>
                          </div>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="monitoring/delete/{{$batch->batch}}"><i class="fas fa-trash-alt"></i> Delete Batch</a>
                            <a class="dropdown-item" data-toggle="tooltip" data-html="true" title="Generates a <b>Tabular</b> report of the batch." data-placement="left" href="monitoring/export-batch/{{$batch->batch}}"><i class="fas fa-file-pdf"></i> Export batch as PDF</a>
                            <a class="dropdown-item" data-toggle="tooltip" data-html="true" title="Generates the individual result of <b>all students</b> of the batch." data-placement="left" href="monitoring/export-batch-individual/{{$batch->batch}}"><i class="fas fa-file-pdf"></i> Export Individual Batch Results</a>
                          </div>


                        </td>

                      </tr>
                        @endforeach

                  </table>
@endsection
