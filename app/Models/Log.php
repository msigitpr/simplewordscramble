<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "log_words";

    protected $fillable = [
        'user_id',
        'word'
    ];
}
