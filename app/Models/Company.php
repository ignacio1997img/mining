<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nit',
        'razon',
        'activity',
        'nim',
        'miningOperator',
        'representative',
        'ci',
        'phone',
        'municipe',
        'status',
        'registerUser_id',
        'deleted_at'
    ];
}
