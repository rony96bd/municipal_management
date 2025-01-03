<?php

namespace App\Models\menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SubMenuModel extends Model
{
    use HasFactory;

    protected $table = 'sub_menus';

    protected $fillable = [
        'top_menu_id',
        'forigen_id',
        'forigen_type',
        'order',
        'link_text',
        'link_url',
        'tab',
    ];

    /**
     * Relationship: SubMenu belongs to a TopMenu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topMenu()
    {
        return $this->belongsTo(MenuModel::class, 'top_menu_id');
    }

    /**
     * Polymorphic relationship: SubMenu belongs to a parent model.
     *
     * @return MorphTo
     */
    public function forigen(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Recursive Relationship: SubMenu can have its own SubMenus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subMenus()
    {
        return $this->hasMany(SubMenuModel::class, 'top_menu_id');
    }
}
