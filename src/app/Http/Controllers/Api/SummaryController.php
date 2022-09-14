<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Construction;
use Carbon\Carbon;

class SummaryController extends Controller
{
    public function profit(Request $request)
    {
        $year = $request->year;
        $supervisor = $request->supervisor;
        $ad = warekiToAd($year);

        $constructions = Construction::where('year', 'like', '%'.$year.'%')->orderBy('number', 'asc')->where('supervisor', $supervisor)->get();
        return $this->profitHelper($ad, $constructions);
    }

    private function profitHelper($ad, $constructions)
    {
        $formattedConstructions = [];
        foreach ($constructions as $construction) {
            $progresses = $this->getFormattedProgresses($ad, $construction->progress);
            $amounts = $this->getFormattedAmounts($ad, $construction);
            $budgets = $this->getFormattedBudgets($ad, $construction);
            $summarise = $this->getSummarise($progresses, $amounts, $budgets);
            $formattedAmountsAndBudgets = $this->getFormattedAmountsAndBudgets($amounts, $budgets);

            $formattedConstructions[] = [
                'id' => $construction['id'],
                'number' => $construction['number'],
                'name' => $construction['name'],
                'summarise' => $summarise,
                'formattedAmountsAndBudgets' => $formattedAmountsAndBudgets
            ];
        }

        return $formattedConstructions;
    }

    private function getFormattedProgresses(int $year, array $progresses)
    {
        $formattedProgresses = [];

        $progressValue = 0;
        foreach (config('util.months.all') as $month) {
            $thisMonthProgress = ['value' => 0, 'datetime' => null];
            foreach ($progresses as $progress) {
                $progressDatetime = new Carbon($progress['datetime']);

                if ($month >= 4) {
                    $firstOfMonth = Carbon::create($year, $month, 1)->firstOfMonth();
                    $lastOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
                } else {
                    $firstOfMonth = Carbon::create($year+1, $month, 1)->firstOfMonth();
                    $lastOfMonth = Carbon::create($year+1, $month, 1)->endOfMonth();
                }

                if($progressDatetime->between($firstOfMonth, $lastOfMonth)) {
                    // その月で最後に更新した値を正とする
                    if (is_null($thisMonthProgress['datetime'])) {
                        $thisMonthProgress = $progress;
                    } else {
                        $thisMonthProgressDatetime = new Carbon($thisMonthProgress['datetime']);
                        if($progressDatetime->gt($thisMonthProgressDatetime)) {
                            $thisMonthProgress = $progress;
                        }
                    }
                }
            }

            // 変更があった場合だけ更新、変更がない場合は前回の数値を引き継ぐ
            if(!is_null($thisMonthProgress['datetime'])) {
                $progressValue = $thisMonthProgress['value'];
            }

            $formattedProgresses[''.$month] = $progressValue;
        }

        return $formattedProgresses;
    }

    private function getFormattedAmounts(int $year, object $construction)
    {
        // 前から埋めることを想定
        $price = $construction['price'];
        $price_spare1 = $construction['price_spare1'];
        $price_spare2 = $construction['price_spare2'];
        $price_spare3 = $construction['price_spare3'];
        $price_spare4 = $construction['price_spare4'];
        $price_spare1_created_at = Carbon::create($construction['price_spare1_created_at']);
        $price_spare2_created_at = Carbon::create($construction['price_spare2_created_at']);
        $price_spare3_created_at = Carbon::create($construction['price_spare3_created_at']);
        $price_spare4_created_at = Carbon::create($construction['price_spare4_created_at']);

        $formattedAmounts = [];
        foreach (config('util.months.all') as $month) {
            $formattedAmounts[$month] = $price;
        }

        $price_spares = [
            [$price_spare1, $price_spare1_created_at],
            [$price_spare2, $price_spare2_created_at],
            [$price_spare3, $price_spare3_created_at],
            [$price_spare4, $price_spare4_created_at]
        ];

        foreach (config('util.months.all') as $month) {
            if ($month >= 4) {
                $datetime = Carbon::create($year, $month, 1)->endOfMonth();
            } else {
                $datetime = Carbon::create($year+1, $month, 1)->endOfMonth();
            }

            foreach ($price_spares as $p) {
                $price_spare = $p[0];
                $price_spare_created_at = $p[1];

                if (is_null($price_spare)) continue;

                if($datetime->gt($price_spare_created_at)) {
                    $formattedAmounts[$month] += $price_spare;
                }
            }
        }

        return $formattedAmounts;
    }

    private function getFormattedBudgets(int $year, object $construction)
    {
        // 前から埋めることを想定
        $budget = $construction['budget'];
        $budget_spare1 = $construction['budget_spare1'];
        $budget_spare2 = $construction['budget_spare2'];
        $budget_spare3 = $construction['budget_spare3'];
        $budget_spare4 = $construction['budget_spare4'];
        $budget_spare1_created_at = Carbon::create($construction['budget_spare1_created_at']);
        $budget_spare2_created_at = Carbon::create($construction['budget_spare2_created_at']);
        $budget_spare3_created_at = Carbon::create($construction['budget_spare3_created_at']);
        $budget_spare4_created_at = Carbon::create($construction['budget_spare4_created_at']);

        $formattedBudgets = [];
        foreach (config('util.months.all') as $month) {
            $formattedBudgets[$month] = $budget;
        }

        $budget_spares = [
            [$budget_spare1, $budget_spare1_created_at],
            [$budget_spare2, $budget_spare2_created_at],
            [$budget_spare3, $budget_spare3_created_at],
            [$budget_spare4, $budget_spare4_created_at]
        ];

        foreach (config('util.months.all') as $month) {
            if ($month >= 4) {
                $datetime = Carbon::create($year, $month, 1)->endOfMonth();
            } else {
                $datetime = Carbon::create($year+1, $month, 1)->endOfMonth();
            }

            foreach ($budget_spares as $p) {
                $budget_spare = $p[0];
                $budget_spare_created_at = $p[1];

                if (is_null($budget_spare)) continue;

                if($datetime->gt($budget_spare_created_at)) {
                    $formattedBudgets[$month] += $budget_spare;
                }
            }
        }

        return $formattedBudgets;
    }

    // todo 繰越どうする
    private function getSummarise($progress, $amounts, $budgets)
    {
        $rows = [];

        $grossSalesSum = 0;
        $profitSum = 0;
        foreach (config('util.months.all') as $month) {
            $grossSales = ($amounts[$month]-$grossSalesSum) - ($amounts[$month] * ((100-$progress[$month])/100));
            $grossSalesSum += $grossSales;

            $grossProfit = $amounts[$month] - $budgets[$month];
            $profit = ($grossProfit-$profitSum) - ($grossProfit * ((100-$progress[$month])/100));
            $profitSum += $profit;

            $rows += [
                $month => [
                    'progres' => $progress[$month],
                    'grossSales' => $grossSales,
                    'profit' => $profit
                ]
            ];
        }

        $rows += [
            'total' => [
                'progres' => $progress[3],
                'grossSales' => $grossSalesSum,
                'profit' => $profitSum
            ]
        ];

        return $rows;
    }

    // WARNING: 別々の月にamountとbudgetを更新すると最大で10となり5を超えて表示されないが、この値を計算に使用してないので答えは正しい
    private function getFormattedAmountsAndBudgets(array $amounts, array $budgets)
    {
        $formattedAmountsAndBudgets = [
            0 => [
                'amount' => '',
                'budget' => '',
                'profit' => '',
                'month' => ''
            ]
        ];
        for ($i=1; $i<=5; $i++) {
            $formattedAmountsAndBudgets[$i] = $formattedAmountsAndBudgets['0'];
        }

        $index = 1;
        foreach (config('util.months.all') as $month) {
            if ($formattedAmountsAndBudgets[$index-1]['amount'] !== $amounts[$month] || $formattedAmountsAndBudgets[$index-1]['budget'] !== $budgets[$month]) {
                $formattedAmountsAndBudgets[$index]['amount'] = $amounts[$month];
                $formattedAmountsAndBudgets[$index]['budget'] = $budgets[$month];
                $formattedAmountsAndBudgets[$index]['profit'] = $amounts[$month] - $budgets[$month];
                $formattedAmountsAndBudgets[$index]['month'] = $month;

                $index += 1;
            }
        }

        return $formattedAmountsAndBudgets;
    }
}
