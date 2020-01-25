<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['faculty_name', 'faculty_description'];

    protected $table = 'faculties';

    protected $primaryKey = 'id_faculty';
}
