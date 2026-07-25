<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Internship;
use App\Models\Selection;

class DashboardController extends Controller
{
    /**
     * ダッシュボードを表示
     */
    public function index()
    {
        $userId = auth()->id();

        // 企業件数
        $companyCount = Company::where('user_id', $userId)->count();

        // インターンシップ件数
        $internshipCount = Internship::where('user_id', $userId)
            ->where('joined', false)
            ->count();

        // 選考未終了件数
        $selectionCount = Selection::where('user_id', $userId)
            ->where('status', 'noFinish')
            ->count();

        $upcomingEvents = collect()
            ->concat(
                Internship::with('company')
                    ->where('user_id', $userId)
                    ->whereNotNull('start_datetime')
                    ->where('start_datetime', '>=', now())
                    ->get()
                    ->map(function ($internship) {
                        return [
                            'type' => 'internship',
                            'datetime' => $internship->start_datetime,
                            'name' => $internship->name,
                            'company' => $internship->company->name,
                            'place' => $internship->place,
                            'url' => route('internship', [
                                'searchI' => $internship->company->name,
                            ]),
                        ];
                    })
            )
            ->concat(
                Selection::with('company')
                    ->where('user_id', $userId)
                    ->whereNotNull('selection_datetime')
                    ->where('selection_datetime', '>=', now())
                    ->get()
                    ->map(function ($selection) {
                        return [
                            'type' => 'selection',
                            'datetime' => $selection->selection_datetime,
                            'name' => $selection->step,
                            'company' => $selection->company->name,
                            'place' => $selection->place,
                            'url' => route('selection', [
                                'searchS' => $selection->company->name,
                            ]),
                        ];
                    })
            )
            ->sortBy('datetime')
            ->take(5)
            ->values();

        return view('dashboard', compact(
            'companyCount',
            'internshipCount',
            'selectionCount',
            'upcomingEvents'
        ));
    }
}
