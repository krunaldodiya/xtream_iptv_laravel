<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskReward extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    protected $casts = [
        'sl' => 'float',
        'tgt' => 'float',
        'tsl' => 'float',
        'stoploss' => 'float',
        'trailing_stoploss' => 'float',
        'target' => 'float',
        'price' => 'float',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
