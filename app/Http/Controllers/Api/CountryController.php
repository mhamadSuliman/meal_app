<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    // 📌 جلب كل الدول
    public function index()
    {
        return response()->json(
            Country::orderBy('name')->get()
        );
    }

    // 📌 عرض دولة مع مدنها (اختياري مفيد جداً)
    public function show($id)
    {
        $country = Country::with('cities')->findOrFail($id);

        return response()->json($country);
    }
}