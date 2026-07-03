<?php

namespace App\Http\Controllers;

use App\Models\Company;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'level' => 'required|integer|min:1|max:5',
            'address' => 'nullable|max:255',
            'industry' => 'nullable|max:50',
            'salary' => 'nullable|integer|min:0',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'break_time' => 'nullable',
            'training_period' => 'nullable|max:50',
            'ses_level' => 'required|max:16',
            'benefits_memo' => 'nullable',
            'free_memo' => 'nullable',
        ]);

        Company::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'level' => $request->level,
            'address' => $request->address,
            'industry' => $request->industry,
            'salary' => $request->salary,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_time' => $request->break_time,
            'training_period' => $request->training_period,
            'ses_level' => $request->ses_level,
            'benefits_memo' => $request->benefits_memo,
            'free_memo' => $request->free_memo,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|max:255',
            'level' => 'required|integer|min:1|max:5',
            'address' => 'nullable|max:255',
            'industry' => 'nullable|max:50',
            'salary' => 'nullable|integer|min:0',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'break_time' => 'nullable',
            'training_period' => 'nullable|max:50',
            'ses_level' => 'required|max:16',
            'benefits_memo' => 'nullable',
            'free_memo' => 'nullable',
        ]);

        $company->update([
            'name' => $request->name,
            'level' => $request->level,
            'address' => $request->address,
            'industry' => $request->industry,
            'salary' => $request->salary,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_time' => $request->break_time,
            'training_period' => $request->training_period,
            'ses_level' => $request->ses_level,
            'benefits_memo' => $request->benefits_memo,
            'free_memo' => $request->free_memo,
        ]);

        return redirect()->route('company');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('company');
    }
}
