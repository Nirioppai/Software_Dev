@extends('layouts.app')

@section('title')
<title>OLSAT</title>
@endsection

@section('content')
Hello, {{ Auth::user()->name}}!
@endsection
