<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    // public function students()
    // {
    //     return view('students');
    // }
    public function csv()
    {
        $success = ('idle');
        return view('csv')->with('success', $success);
  
    }
    public function monitoring()
    {
        return view('monitoring');
    }

        public function uploadStudent()
    {
        return view('csv_student_upload');
    }

    public function uploadReferences()
    {
        $scaled_score = 1;
        $success = ('idle');
        return view('csv_references')->with('scaled_score', $scaled_score)->with('success', $success);
    }


}
