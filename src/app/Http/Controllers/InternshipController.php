<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Internship;

use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::with('company')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('internships.index', compact('internships'));
    }

    public function create()
    {
        $companies = Company::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('internships.create', compact('companies'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|max:255',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'break_time' => 'nullable|integer|min:0',
            'place' => 'nullable|max:255',
            'station' => 'nullable|max:255',
            'content' => 'nullable|string',
            'carfare' => 'nullable|boolean',
            'carfare_price' => 'nullable|integer|min:0',
            'lunch' => 'nullable|boolean',
            'url' => 'nullable|url',
            'applied' => 'boolean',
            'joined' => 'boolean',
            'joined_memo' => 'nullable|string',
        ]);

        $request->merge([
            'applied' => $request->boolean('applied'),
            'joined' => $request->boolean('joined'),
            'lunch' => $request->boolean('lunch'),
            'carfare' => $request->boolean('carfare'),
        ]);

        $internship = Internship::create([
            'user_id' => auth()->id(),
            'company_id' => $request->company_id,
            'name' => $request->name,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'break_time' => $request->break_time,
            'place' => $request->place,
            'station' => $request->station,
            'content' => $request->content,
            'carfare' => $request->carfare,
            'carfare_price' => $request->carfare_price,
            'lunch' => $request->lunch,
            'url' => $request->url,
            'applied' => $request->applied,
            'joined' => $request->joined,
            'joined_memo' => $request->joined_memo,
        ]);

        return redirect()
            ->route('internship')
            ->with('success', 'インターンシップを登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Internship $internship)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship $internship)
    {
        $companies = Company::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('internships.edit', compact('internship', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Internship $internship)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|max:255',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'break_time' => 'nullable|integer|min:0',
            'place' => 'nullable|max:255',
            'station' => 'nullable|max:255',
            'content' => 'nullable|string',
            'carfare' => 'nullable|boolean',
            'carfare_price' => 'nullable|integer|min:0',
            'lunch' => 'nullable|boolean',
            'url' => 'nullable|url',
            'applied' => 'boolean',
            'joined' => 'boolean',
            'joined_memo' => 'nullable|string',
        ]);

        $request->merge([
            'applied' => $request->boolean('applied'),
            'joined' => $request->boolean('joined'),
            'lunch' => $request->boolean('lunch'),
            'carfare' => $request->boolean('carfare'),
        ]);

        $internship->update([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'break_time' => $request->break_time,
            'place' => $request->place,
            'station' => $request->station,
            'content' => $request->content,
            'carfare' => $request->carfare,
            'carfare_price' => $request->carfare_price,
            'lunch' => $request->lunch,
            'url' => $request->url,
            'applied' => $request->applied,
            'joined' => $request->joined,
            'joined_memo' => $request->joined_memo,
        ]);

        return redirect()->route('internship');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
    {
        $internship->delete();
        return redirect()->route('internship');
    }
}
