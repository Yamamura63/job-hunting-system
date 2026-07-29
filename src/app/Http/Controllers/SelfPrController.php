<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelfPrController extends Controller
{
    public function index()
    {
        return view('self_prs.index');
    }

    public function create()
    {
        return view('self_prs.create');
    }

    public function edit()
    {
        return view('self_prs.edit');
    }
}
