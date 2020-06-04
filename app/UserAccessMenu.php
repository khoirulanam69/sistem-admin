<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccessMenu extends Model
{
    protected $table = "table_user_access_menu";

    public function menu()
    {
        return $this->belongsTo('App\UserMenu');
    }
}
