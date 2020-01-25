<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['program_name', 'modality', 'status', 'fk_faculty', 'fk_campus' ];

    protected $table = 'programs';

    protected $primaryKey = 'id_program';
}
