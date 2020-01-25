<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role_name'];

    protected $table = 'roles';

    protected $primaryKey = 'id_role';
}
