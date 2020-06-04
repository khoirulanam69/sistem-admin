<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubMenu extends Model
{
    use SoftDeletes;
    protected $table = "table_user_sub_menu";

    protected $fillable = ['menu_id', 'title', 'icon', 'url', 'is_active'];
}
