<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submenu extends Model
{
    use SoftDeletes;

    protected $fillable = ['menu_id', 'title', 'icon', 'url', 'is_active'];

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
