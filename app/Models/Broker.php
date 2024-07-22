<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    protected $casts = [
        'broker_config' => 'json',
    ];

    public function available_broker()
    {
        return $this->belongsTo(AvailableBroker::class);
    }
}
