@extends('components.bars')

@section('title')
<title>OLSAT | Dashboard</title>
@endsection

@section('nav')
<!-- Navigation -->
<ul class="navbar-nav">
  <li class="nav-item active">
    <a class="nav-link active" href="/home">
      <i class="ni ni-tv-2 text-primary"></i> Dashboard
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="/students">
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
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="/home/register">
      <i class="fas fa-user-circle"></i> Accounts
    </a>
  </li>
</ul>

<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="/home/history">
      <i class="fas fa-history"></i> Action Log
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
  <a class="current-breadcrumb text-dark">Dashboard</a>
</div>
@endsection

@section('content')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <span class="badge badge-pill badge-warning"><div class="text-dark"><i class="fas fa-exclamation-triangle"></i> Warning</div></span> You have not uploaded a batch of students yet. <a href="#" class="alert-link">Click here to upload now</a>.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="alert alert-warning alert-dismissible fade show" role="alert">
  
  <h4 class="alert-heading"><span class="badge badge-pill badge-warning"><div class="text-dark"><i class="fas fa-exclamation-triangle"></i> Warning</div></span></h4>
  <p>You have not uploaded a batch of students yet.</p>
  <hr class="mt--2">
  <p class="mb-0 mt--4"><a href="#" class="alert-link">Click here to upload now</a>.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="row mt--3">
  
  <div class="col">
      <div class="card">
        <div class="card-header">
          {!! Form::open(['url' => 'home/sort/{batch}', 'method' => 'GET']) !!}
          @csrf
            <div class="row">
              <div class="col-sm">
                OLSAT Batch Report
              </div>
            <div class="col-sm ">
              <div class="form-inline float-right">
                <label>Batch Number:</label>
                <select class="form-control-sm ml-3" onchange="this.form.submit()" name="batchFilter">
                  <option hidden value="{{$batchSelected}}" selected>{{$batchSelected}}</option>
                  @foreach($meanResults as $batchNumber)
                    <option value={{$batchNumber->batch}}>{{$batchNumber->batch}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          
        </div>
      </div>
      <div class="card-body">
        {!! $OLSATBar->container() !!}
      </div>
    </div>
  </div>


  <div class="col">
      <div class="card">
        <div class="card-header">

            <div class="row">
              <div class="col-sm">
                Batch Results trend line
              </div>
            <div class="col-sm ">
              <div class="form-inline float-right">
                <label>Filter:</label>
                <select class="form-control-sm ml-3" onchange="this.form.submit()" name="fieldFilter">
                  <option hidden value="{{$filterSelected}}" selected>{{$filterSelected}}</option>
                  <option value='Raw'>Raw</option>
                  <option value='Scaled'>Scaled</option>
                  <option value='SAI'>SAI</option>
                  <option value='Percentile'>Percentile</option>
                  <option value='Stanine'>Stanine</option>
                </select>
              </div>
            </div>
            </form>
        </div>
      </div>
      <div class="card-body">
        {!! $OLSATLine->container() !!}
      </div>
    </div>
  </div>
</div>
@endsection

@section('chart_scripts')
{{-- ChartScript --}}
    @if($OLSATBar)
    {!! $OLSATBar->script() !!}
    {!! $OLSATLine->script() !!}
    @endif
@endsection

