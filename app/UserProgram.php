<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProgram extends Model
{
    protected $fillable = ['fk_user', 'fk_program'];

    protected $table = 'user_program';

    protected $primaryKey = 'id_user_program';

}
