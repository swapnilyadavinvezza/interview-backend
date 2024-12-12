<?php

namespace App\Models;

use App\Models\Booklet;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamEnrollment extends Model
{
    use SoftDeletes;
    
    // Define the fillable columns in the table
    protected $fillable = [
        'booklet_id',
        'exam_date',
        'status',
        'marks_obtained',
        'comments',
        'user_id',
    ];

    // if your table has timestamps (created_at and updated_at)
    public $timestamps = true;

    // Define the relationship with the Booklet model (each enrollment belongs to one booklet)
    public function booklet()
    {
        return $this->belongsTo(Booklet::class, 'booklet_id');
    }

    // Define the relationship with the User model (each enrollment belongs to one user)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
