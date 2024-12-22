<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function MenuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
