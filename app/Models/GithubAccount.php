<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GithubAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    protected $hidden = ['access_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function github_repositories()
    {
        return $this->hasMany(GithubRepository::class, 'github_account_id');
    }
}
