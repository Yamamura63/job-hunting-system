<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * 一覧
     */
    public function index()
    {
        $companies = Company::with('urls')
            ->latest()
            ->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * 登録画面
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * 編集画面
     */
    public function edit($id)
    {
        return view('companies.edit', [
            'id' => $id
        ]);
    }
}
