<?php

namespace App\Services\Summaries;

use Carbon\Carbon;

class ComprehensiveService
{
    // TODO 合計処理書いて バックエンドに寄せた後です
    public function get($memberFormattedOrder, $memberFormattedProfit)
    {
        return [
            $memberFormattedProfit,
            $memberFormattedOrder
        ];
    }
}
