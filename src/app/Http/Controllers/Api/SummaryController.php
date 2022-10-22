<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Construction;
use App\Services\Summaries\ProfitService;
use App\Services\Summaries\OrderService;
use App\Services\Summaries\ComprehensiveService;

class SummaryController extends Controller
{
    // WARNING: yearを元に集計しているため、契約日がyearの範囲を超えていても集計される場合がある
    public function order(Request $request, Construction $construction, OrderService $orderService)
    {
        $year = $request->year;
        $sales = $request->sales;

        $constructions = $construction->where('year', 'like', $year.'%')->where('sales', $sales)->orderBy('contract_date', 'asc')->orderBy('number', 'asc')->get();
        return $orderService->getFormattedOrders($constructions);
    }

    public function profit(Request $request, Construction $construction, ProfitService $profitService)
    {
        $year = $request->year;
        $supervisor = $request->supervisor;
        $ad = warekiToAd($year);

        $constructions = $construction->where('year', 'like', '%'.$year.'%')->where('supervisor', $supervisor)->orderBy('number', 'asc')->get();
        return $profitService->getFormattedProfits($ad, $constructions);
    }

    public function comprehensive(Request $request, Construction $construction, OrderService $orderService, ProfitService $profitService, ComprehensiveService $comprehensiveService)
    {
        $year = $request->year;

        $constructions = $construction->where('year', 'like', '%'.$year.'%')->orderBy('number', 'asc')->get();
        $members = array_filter(
            $constructions->pluck("supervisor")->merge(
            $constructions->pluck("sales"))
            ->unique()->all()
        );

        $res = [];
        foreach ($members as $member) {
            $memberOrder = $constructions->filter(function ($value, $key) use($member) {
                return $value->sales === $member;
            });
            $memberFormattedOrder = $orderService->getFormattedOrders($memberOrder);

            $memberProfit = $constructions->filter(function ($value, $key) use($member) {
                return $value->supervisor === $member;
            });
            $memberFormattedProfit = $profitService->getFormattedProfits($ad, $memberProfit);

            $comprehensive = $comprehensiveService->get($memberFormattedOrder, $memberFormattedProfit);
            $r[$member] = $comprehensive;
        }

        return $res;
    }
}
