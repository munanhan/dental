<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function privileges()
    {
        return $this->belongsToMany('App\Privilege');
    }
}
