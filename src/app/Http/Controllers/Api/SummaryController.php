<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Construction;
use App\Services\Summaries\ProfitService;

class SummaryController extends Controller
{
    public function profit(Request $request, Construction $construction, ProfitService $profitService)
    {
        $year = $request->year;
        $supervisor = $request->supervisor;
        $ad = warekiToAd($year);

        $constructions = $construction->where('year', 'like', '%'.$year.'%')->orderBy('number', 'asc')->where('supervisor', $supervisor)->get();
        return $profitService->getFormattedProfits($ad, $constructions);
    }

    // WARNING: yearを元に集計しているため、契約日がyearの範囲を超えていても集計される場合がある
    public function order(Request $request, Construction $construction)
    {
        $year = $request->year;
        $sales = $request->sales;

        $constructions = $construction->where('year', 'like', $year.'%')->orderBy('contract_date', 'asc')->orderBy('number', 'asc')->where('sales', $sales)->get();
        return $constructions;
    }
}
