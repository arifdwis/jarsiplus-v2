<?php

namespace App\Domain\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri', 'permission'];
    public $timestamps = true;

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_menu', 'menu_id', 'role_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }
}
