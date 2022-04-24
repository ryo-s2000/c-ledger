<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Construction extends Model
{
    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'contract_date' => 'datetime:Y-m-d',
        'billing_date' => 'datetime:Y-m-d',
        'payment_date' => 'datetime:Y-m-d',
        'start' => 'datetime:Y-m-d',
        'end' => 'datetime:Y-m-d',
        'period_spare1' => 'datetime:Y-m-d',
        'period_spare2' => 'datetime:Y-m-d',
        'period_spare3' => 'datetime:Y-m-d',
        'period_spare4' => 'datetime:Y-m-d',
    ];

    protected $appends = [
        'price_tax',
        'total_price'
    ];

    public function getPriceTaxAttribute()
    {
        return $this->price * $this->tax / 100;
    }

    public function getTotalPriceAttribute()
    {
        return $this->price + $this->price_tax + $this->price_spare1 + $this->price_spare2 + $this->price_spare3 + $this->price_spare4;
    }
}
