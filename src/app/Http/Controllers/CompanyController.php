<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * 企業一覧を表示
     */
    public function index()
    {
        // 企業と関連するURLをまとめて取得
        $companies = Company::with('urls')
            ->latest()
            ->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * 企業登録画面を表示
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * 企業編集画面を表示
     */
    public function edit(Company $company)
    {
        // 編集画面でURLも使用するため取得
        $company->load('urls');

        return view('companies.edit', compact('company'));
    }
}
