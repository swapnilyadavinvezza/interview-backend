<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookletAnswer extends Model
{
    protected $fillable = ['user_id', 'booklet_id', 'question_id', 'answer','status'];

}
