<?php

namespace App\Http\Controllers;

use App\Models\Company;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::where('user_id', auth()->id());

        // 企業名検索
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 志望度順の並べ替え
        if ($request->sort === 'high') {
            $query->orderByDesc('level');
        } elseif ($request->sort === 'low') {
            $query->orderBy('level');
        } else {
            // デフォルト：登録日時の新しい順
            $query->latest();
        }

        $companies = $query->get();

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
            'basic_salary' => 'nullable|integer|min:0',
            'other_salary' => 'nullable|integer|min:0',
            'salary' => 'nullable|integer|min:0',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'break_time' => 'nullable',
            'training_year' => 'nullable|integer|min:0',
            'training_month' => 'nullable|integer|min:0|max:11',
            'ses_level' => 'required|max:16',
            'urls.*.url' => 'nullable|url|max:255',
            'urls.*.memo' => 'required_with:urls.*.url|max:100',
            'benefits_memo' => 'nullable',
            'free_memo' => 'nullable',
        ]);

        $trainingPeriod = ($request->training_year ?? 0) * 12 + ($request->training_month ?? 0);

        $company = Company::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'level' => $request->level,
            'address' => $request->address,
            'industry' => $request->industry,
            'basic_salary' => $request->basic_salary ?? 0,
            'other_salary' => $request->other_salary ?? 0,
            'salary' => $request->salary ?? 0,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_time' => $request->break_time ?? 0,
            'training_period' => $trainingPeriod,
            'ses_level' => $request->ses_level,
            'benefits_memo' => $request->benefits_memo,
            'free_memo' => $request->free_memo,
        ]);

        foreach ($request->input('urls', []) as $url) {
            if (empty($url['url']) && empty($url['memo'])) {
                continue;
            }

            $company->urls()->create([
                'url' => $url['url'],
                'memo' => $url['memo'],
            ]);
        }

        return redirect()->route('company');
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
        $company->load('urls');
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
            'basic_salary' => 'nullable|integer|min:0',
            'other_salary' => 'nullable|integer|min:0',
            'salary' => 'nullable|integer|min:0',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'break_time' => 'nullable',
            'training_year' => 'nullable|integer|min:0',
            'training_month' => 'nullable|integer|min:0|max:11',
            'ses_level' => 'required|max:16',
            'urls.*.url' => 'nullable|url|max:255',
            'urls.*.memo' => 'required_with:urls.*.url|max:100',
            'benefits_memo' => 'nullable',
            'free_memo' => 'nullable',
        ]);

        $trainingPeriod = ($request->training_year ?? 0) * 12 + ($request->training_month ?? 0);

        $company->update([
            'name' => $request->name,
            'level' => $request->level,
            'address' => $request->address,
            'industry' => $request->industry,
            'basic_salary' => $request->basic_salary,
            'other_salary' => $request->other_salary,
            'salary' => $request->salary,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_time' => $request->break_time,
            'training_period' => $trainingPeriod,
            'ses_level' => $request->ses_level,
            'benefits_memo' => $request->benefits_memo,
            'free_memo' => $request->free_memo,
        ]);

        $company->urls()->delete();

        foreach ($request->input('urls', []) as $url) {
            if (empty($url['url']) && empty($url['memo'])) {
                continue;
            }

            $company->urls()->create([
                'url' => $url['url'],
                'memo' => $url['memo'],
            ]);
        }

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
