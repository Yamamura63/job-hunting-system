<?php

namespace App\Http\Controllers;

use App\Models\SelfPr;

use Illuminate\Http\Request;

class SelfPrController extends Controller
{
    public function index()
    {
        $selfPrs = SelfPr::all();

        return view('self_prs.index', compact('selfPrs'));
    }

    public function create()
    {
        return view('self_prs.create');
    }

    public function store(Request $request)
    {
        SelfPr::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('selfPr.index');
    }
}
