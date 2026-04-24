<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;

class CityController extends Controller
{
    // 📌 جلب كل المدن
    public function index()
    {
        return response()->json(
            City::with('country')->orderBy('name')->get()
        );
    }

    // 📌 جلب مدن حسب الدولة (الأهم عندك)
    public function byCountry($countryId)
    {
        return response()->json(
            City::where('country_id', $countryId)
                ->orderBy('name')
                ->get()
        );
    }

    // 📌 عرض مدينة واحدة (اختياري)
    public function show($id)
    {
        return response()->json(
            City::with('country')->findOrFail($id)
        );
    }
}