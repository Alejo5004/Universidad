<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = ['campus_name', 'campus_address'];

    protected $table = 'campuses';
}
