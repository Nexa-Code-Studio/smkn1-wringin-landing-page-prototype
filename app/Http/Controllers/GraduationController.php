<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraduationController extends Controller
{
    public function index()
    {
        return view('graduation.index');
    }

    public function admin()
    {
        return view('graduation.admin');
    }
}
