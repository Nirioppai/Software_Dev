@extends('layouts.app')

@section('title')
<title>OLSAT | Register</title>
@endsection

@section('body')
<body class="bg-default">
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div class="main-content">
    <!-- Navbar -->

    <!-- Header -->
    <div class="header bg-gradient-yellow py-8 py-lg-8">
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--9 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-7 ">
        
          {!! Form::open(['url' => '/register/submit', 'class' => 'bg-white text-center border border-light p-5 ', 'method' => 'POST']) !!}
            @csrf
            <img src="{{asset('./img/brand/brand_downscaled.png')}}" class=" text-left mt--4" alt="...">
            <p class="h2 mt-2 text-left text-center">Create an account</p>

            <div class="md-form mt--1">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror mt-3" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="materialLoginFormName"><i class="ni ni-circle-08"></i> <small>Name</small></label>
            </div>

            <div class="md-form mt--1">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="materialLoginFormUsername"><i class="fas fa-id-card-alt"></i> <small>Username</small></label>
            </div>

            <div class="md-form mt--1">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                <label for="materialLoginFormPassword"><i class="ni ni-lock-circle-open"></i> <small>Password</small></label>
            </div>

            <div class="md-form mt--1">
                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                <label for="materialLoginFormConfirmPassword"><i class="fas fa-lock"></i> <small>Confirm Password</small></label>
            </div>

            <div class="text-center">
            <button type="submit" class="btn  btn-outline-xs-blue mb--3">
                {{ __('Register') }}
            </button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <footer>
      <div class="container my-1 ">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              © 2018 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1 text-white" target="_blank">Creative Tim</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link text-muted" target="_blank">MIT License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
</body>
@endsection
