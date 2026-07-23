<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Selection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SelectionController extends Controller
{
    /**
     * 選考一覧を表示
     */
    public function index()
    {
        $selections = Selection::where('user_id', auth()->id())
            ->with('company')
            ->latest()
            ->get();

        return view('selections.index', compact('selections'));
    }

    /**
     * 選考登録画面を表示
     */
    public function create()
    {
        $companies = Company::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('selections.create', compact('companies'));
    }

    /**
     * 選考を登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'  => 'required|exists:companies,id',
            'step'  => 'required|string|max:50',
            'selection_datetime'  => 'nullable|date',
            'place'  => 'nullable|string|max:255',
            'station'  => 'nullable|string|max:255',
            'carfare' => 'nullable|boolean',
            'carfare_price'  => 'nullable|integer|min:0',
            'clothing'  => 'nullable|string|max:255',
            'items'  => 'nullable|string',
            'free_memo'  => 'nullable|string',
            'result_period'  => 'nullable|max:50',
            'status' => 'required|in:noFinish,finish,result',
        ]);

        $validated['user_id'] = auth()->id();

        Selection::create($validated);

        return redirect()
            ->route('selection')
            ->with('success', '選考情報を登録しました。');
    }

    /**
     * 選考詳細を表示
     */
    public function show(Selection $selection)
    {
        abort_unless($selection->user_id === auth()->id(), 403);

        $selection->load('company');

        return view('selections.show', compact('selection'));
    }

    /**
     * 選考編集画面を表示
     */
    public function edit(Selection $selection)
    {
        abort_unless($selection->user_id === auth()->id(), 403);

        $companies = Company::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('selections.edit', compact('selection', 'companies'));
    }

    /**
     * 選考情報を更新
     */
    public function update(Request $request, Selection $selection)
    {
        abort_unless($selection->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'company_id' => [
                'required',
                Rule::exists('companies', 'id')
                    ->where('user_id', auth()->id()),
            ],
            'step'  => 'required|string|max:50',
            'selection_datetime'  => 'nullable|date',
            'place'  => 'nullable|string|max:255',
            'station'  => 'nullable|string|max:255',
            'carfare' => 'nullable|boolean',
            'carfare_price'  => 'nullable|integer|min:0',
            'clothing'  => 'nullable|string|max:255',
            'items'  => 'nullable|string',
            'free_memo'  => 'nullable|string',
            'result_period'  => 'nullable|max:50',
            'status' => 'required|in:noFinish,finish,result',
        ]);

        $selection->update($validated);

        return redirect()
            ->route('selection')
            ->with('success', '選考情報を更新しました。');
    }

    /**
     * 選考情報を削除
     */
    public function destroy(Selection $selection)
    {
        abort_unless($selection->user_id === auth()->id(), 403);

        $selection->delete();

        return redirect()
            ->route('selection')
            ->with('success', '選考情報を削除しました。');
    }
}
