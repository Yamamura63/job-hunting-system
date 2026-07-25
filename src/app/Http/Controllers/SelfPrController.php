<?php

namespace App\Http\Controllers;

use App\Models\SelfPr;

use Illuminate\Http\Request;

class SelfPrController extends Controller
{

    public function index()
    {
        $selfPrs = SelfPr::orderByRaw('LENGTH(body) ASC')
            ->get();
        return view('self_prs.index', compact('selfPrs'));
    }

    public function create()
    {
        return view('self_prs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:100'],
            'body' => ['required'],
        ]);

        SelfPr::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('selfPr');
    }

    public function edit(SelfPr $selfPr)
    {
        return view('self_prs.edit', compact('selfPr'));
    }

    public function update(Request $request, SelfPr $selfPr)
    {
        $request->validate([
            'title' => ['required', 'max:100'],
            'body' => ['required'],
        ]);

        $selfPr->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('selfPr');
    }

    public function destroy(SelfPr $selfPr)
    {
        $selfPr->delete();
        return redirect()->route('selfPr');
    }
}
