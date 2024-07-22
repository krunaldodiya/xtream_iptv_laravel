<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        "expires_at" => "datetime",
    ];

    protected $appends = [
        'plan_status'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function plan_subscriptions()
    {
        return $this->hasMany(PlanSubscription::class);
    }

    public function is_expired(): bool
    {
        return $this->expires_at < now();
    }

    public function is_active(): bool
    {
        return !$this->is_expired();
    }

    public function has_plan(Plan $plan): bool
    {
        return $this->plan->id == $plan->id;
    }

    public function is_downgrading(Plan $plan): bool
    {
        return $this->plan->id > $plan->id;
    }

    protected function planStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_expired() ? "expired" : "active",
        );
    }
}
