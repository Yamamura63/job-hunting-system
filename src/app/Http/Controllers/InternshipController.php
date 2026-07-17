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
            'applied' => 'nullable|boolean',
            'joined' => 'nullable|boolean',
            'joined_memo' => 'nullable|string',
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
