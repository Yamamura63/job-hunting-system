<?php

namespace App\Http\Controllers;
use App\Models\SelfPr;

use Illuminate\Http\Request;

class SelfPrController extends Controller
{
    public function index()
    {
        $selfPrs = SelfPr::all();
        dd($selfPrs);

        return view('self_prs.index', compact('selfPrs'));
    }
}
