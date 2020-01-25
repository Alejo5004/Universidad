<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['id_faculty', 'faculty_name', 'faculty_description', 'description'];

    protected $table = 'faculties';

    protected $primaryKey = 'id_faculty';
}
