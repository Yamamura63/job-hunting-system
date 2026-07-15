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
            'name' => 'required|max:255',
            'start_datetime' => 'nullable',
            'end_datetime' => 'nullable',
            'place' => 'nullable',
            'station' => 'nullable',
            'content' => 'nullable',
            'carfare' => 'nullable|integer|min:0',
            'lunch' => 'nullable|integer|min:0',
            'applied' => 'nullable|boolean',
            'joined' => 'nullable|boolean',
            'joined_memo' => 'nullable'
        ]);

        $app = filter_var(data_get($validated, 'applied', false), FILTER_VALIDATE_BOOLEAN);
        $join = filter_var(data_get($validated, 'joined', false), FILTER_VALIDATE_BOOLEAN);

        $internship = Internship::create([
            'user_id' => auth()->id(),
            'company_id' => $request->company,
            'name' => $request->name,
            'start_datetime' => $request->start_time,
            'end_datetime' => $request->end_time,
            'place' => $request->place,
            'station' => $request->station,
            'content' => $request->content,
            'carfare' => $request->carfare,
            'lunch' => $request->lunch,
            'applied' => $app,
            'joined' => $join,
            'joined_memo' => 'nullable'
        ]);
    }
}
