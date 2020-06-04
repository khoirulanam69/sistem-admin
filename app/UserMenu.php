<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMenu extends Model
{
    use SoftDeletes;

    protected $table = "table_user_menu";

    protected $fillable = ['menu'];

    public function accessmenu()
    {
        return $this->hasMany('App\UserAccessMenu');
    }
}
