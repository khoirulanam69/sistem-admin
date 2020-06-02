<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubMenu extends Model
{
    protected $table = "table_user_sub_menu";

    protected $fillable = ['menu_id', 'title', 'icon', 'url', 'is_active'];
}
