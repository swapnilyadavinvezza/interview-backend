<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booklet extends Model
{
    protected $fillable = [
        'name',
        'level',
        'description',
        'status',
        'total_weightage',
        'created_by',
        'duration'
    ];
}
