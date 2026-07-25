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
    public function index(Request $request)
    {
        $query = Selection::with('company')
            ->where('selections.user_id', auth()->id());

        // 企業名検索
        if ($request->filled('searchS')) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->searchS . '%');
            });
        }

        // 状況で絞り込み
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 並べ替え
        if ($request->sort === 'new') {
            // 開催日時が遅い順
            $query->orderByDesc('selection_datetime');
        } elseif ($request->sort === 'old') {
            // 開催日時が早い順
            $query->orderBy('selection_datetime');
        } elseif ($request->sort === 'company_asc') {
            // 企業名 昇順
            $query->join('companies', 'selections.company_id', '=', 'companies.id')
                ->orderBy('companies.name')
                ->select('selections.*');
        } elseif ($request->sort === 'company_desc') {
            // 企業名 降順
            $query->join('companies', 'selections.company_id', '=', 'companies.id')
                ->orderByDesc('companies.name')
                ->select('selections.*');
        } else {
            // デフォルト：開催日時が遅い順
            $query->orderByDesc('selection_datetime');
        }

        $selections = $query->get();

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
