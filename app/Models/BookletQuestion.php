<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookletQuestion extends Model
{
    protected $fillable = [
        'booklet_id',
        'question_type',
        'marks',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'answer',
        'image',
    ];


    public function booklet()
    {
        return $this->belongsTo(Booklet::class, 'booklet_id', 'id');
    }
}
