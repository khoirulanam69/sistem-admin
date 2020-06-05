<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = ['menu'];

    public function role()
    {
        return $this->belongsToMany('App\Role');
    }

    public function submenus()
    {
        return $this->hasMany('App\Submenu');
    }
}
