<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlgoSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'order_id', 'order_id');
    // }

    // public function positions()
    // {
    //     return $this->hasMany(Position::class, 'position_id', 'position_id');
    // }

    // public function trades()
    // {
    //     return $this->hasMany(Trade::class, 'trade_id', 'trade_id');
    // }
}
