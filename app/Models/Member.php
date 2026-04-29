<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;


    protected $fillable = [
        'name',
        'surname',
        'code',
        'jmbg',
        'register_date',
        'image_path',
        'street',
        'post_no',
        'city',
        'image',
        'email',
        'mobile',
        'status',
        'password',
        'last_seen_obavijesti',
        'last_seen_termini',
        'is_admin',
        'monthly_goal_visits',
        'monthly_goal_minutes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
