<?php

namespace App\Models\menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMenuModel extends Model
{
    use HasFactory;

    protected $table = 'group_menus';

    protected $fillable = [
        'top_menu_id',
        'group_label',
        'order',  // Ensure this is filled with a numeric value
    ];

    // Top Menu relationship
    public function topmenu()
    {
        return $this->belongsTo(MenuModel::class, 'top_menu_id');
    }

    // Submenus relationship
    public function submenus()
    {
        return $this->hasMany(GroupSubmenuModel::class, 'group_menu_id');
    }

    /**
     * Cascade delete related group submenus when a group menu is deleted.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($groupMenuModel) {
            // Delete related group submenus
            $groupMenuModel->submenus()->delete();
        });
    }
}
