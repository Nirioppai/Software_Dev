@extends('components.bars')

@section('title')
<title>OLSAT | Register</title>
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
  <li class="nav-item ">
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
  <li class="nav-item active">
    <a class="nav-link active" href="#">
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
  <div class="row justify-content-center ">
      <div class="col-sm">
      <div class="card">
        <h5 class="card-header">Create an Administrator Account</h5>
        <div class="card-body">
            {!! Form::open(['url' => 'home/register/submit', 'method' => 'POST']) !!}
            @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter name">
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="usernameHelp" placeholder="Enter username">
                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                    <small id="passwordHelp" class="form-text text-muted">Please dont share your password with anyone else.</small>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <div class="form-group">
                    <label for="confirmpassword">Password Confirmation</label>
                    <input id="password-confirm" type="password" class="form-control" placeholder="Password confirm" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            {!! Form::close() !!}
        </div>
    </div>
        </div>

    <div class="col-sm-5">
      <div class="card">
        <h5 class="card-header">Account List</h5>
        <div class="card-body">

            
                    <table class="table align-items-center table-bordered table-striped table-flush  ">
                    <thead class="thead-light">
                        <tr>
                        <th class="text-center text-dark">No.</th>  
                        <th class="text-center text-dark">Name</th>
                        <th class="text-center text-dark">Username</th>
                        </tr>
                    </thead>

                    @foreach($Users as $User)
                        <tr>
                            <td class="text-center">{{$User->id}}</td>
                            <td class="text-left">{{$User->name}}</td>
                            <td class="text-center">{{$User->username}}</td>
                        </tr>
                    @endforeach

                </table>
             </div>
            </div>
        </div>

        
        
    </div>
</div>

@endsection
