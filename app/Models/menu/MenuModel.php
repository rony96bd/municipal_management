<?php

namespace App\Models\menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MenuModel extends Model
{
    use HasFactory;

    protected $table = 'top_menus';

    protected $fillable = [
        'forigen_id',
        'forigen_type',
        'order',
        'link_text',
        'link_url',
        'tab',
    ];

    /**
     * Polymorphic relationship: This will relate to the parent model (e.g., pages, notices, etc.)
     *
     * @return MorphTo
     */
    public function forigen(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relationship: TopMenu has many SubMenus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submenus()
    {
        return $this->hasMany(SubMenuModel::class, 'top_menu_id');
    }
    public function groupmenus()
    {
        return $this->hasMany(GroupMenuModel::class, 'top_menu_id');
    }


    /**
     * Cascade delete related submenus and groupmenus when a top menu is deleted.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($menuModel) {
            // Delete related submenus
            $menuModel->submenus()->delete();

            // Delete related group menus
            $menuModel->groupmenus()->delete();
        });
    }
}
