<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function menu()
    {
        return $this->belongsToMany('App\Menu');
    }
}
