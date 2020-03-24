@extends('layouts.app')

@section('title')
<title>Olsat | Sign in</title>
@endsection

@section('body')
<body class="bg-default">
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-yellow py-7 py-lg-8">
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-7 ">
        
           <form method="POST" class="bg-white text-center border border-light p-5" action="{{ route('login') }}">
            @csrf
            <img src="{{asset('./img/brand/brand.png')}}" class=" text-left mt--4" alt="...">
            <p class="h2 mt-2 text-left">Sign in</p>

            <div class="md-form mt--1">

                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
                <label for="materialLoginFormUsername"><i class="fas fa-id-card-alt"></i> <small>Username</small></label>
            </div>

            <div class="md-form mt--1">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <label for="materialLoginFormPassword"><i class="ni ni-lock-circle-open"></i> <small>Password</small></label>
            </div>

            <div class="text-center">
            <button type="submit" class="btn btn-md btn-outline-primary mb--3">
                {{ __('Sign in') }}
            </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <footer>
      <div class="container mt-5 ">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              © 2020 <a href="#" class="font-weight-bold ml-1 text-white" target="_blank">Radisoft Inc.</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="#" class="nav-link text-muted" target="_blank">Radisoft Inc.</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
</body>
@endsection