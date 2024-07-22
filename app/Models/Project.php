<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function broker()
    {
        return $this->belongsTo(Broker::class, "broker_id");
    }

    public function data_broker()
    {
        return $this->belongsTo(Broker::class, "data_broker_id");
    }

    public function github_repository()
    {
        return $this->belongsTo(GithubRepository::class, 'github_repository_id');
    }

    public function algo_sessions()
    {
        return $this->hasMany(AlgoSession::class);
    }
}
