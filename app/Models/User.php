<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user_plan()
    {
        return $this->hasOne(UserPlan::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function set_plan()
    {
        $plan = Plan::find(1);

        $plan_subscription = PlanSubscription::create([
            'user_id' => $this->id,
            'order_id' => Str::random(16),
            'plan_id' => $plan->id,
            'amount' => $plan->monthly_charges,
            'status' => "paid",
        ]);

        $user_plan = UserPlan::create([
            'user_id' => $this->id,
            'plan_id' => $plan->id,
            'expires_at' => now()->addMonth(1),
        ]);
    }
}
