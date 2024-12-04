<?php

namespace App\Models;

use App\Models\ExamEnrollment;
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

    public function examEnrollment(){
        return $this->hasOne(ExamEnrollment::class, 'booklet_id', 'id');
    }

    public function questions(){
        return $this->hasMany(BookletQuestion::class);
    }
}
