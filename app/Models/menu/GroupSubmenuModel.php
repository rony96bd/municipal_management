<?php

namespace App\Models\menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GroupSubmenuModel extends Model
{
    use HasFactory;

    protected $table = 'group_submenus';

    protected $fillable = [
        'top_menu_id',
        'group_menu_id',
        'forigen_id',
        'forigen_type',
        'order',
        'link_text',
        'link_url',
        'tab',
    ];

    // Top Menu relationship
    public function topMenu()
    {
        return $this->belongsTo(MenuModel::class, 'top_menu_id');
    }

    // Polymorphic relationship
    public function forigen(): MorphTo
    {
        return $this->morphTo();
    }

    // Group Menu relationship
    public function groupmenu()
    {
        return $this->belongsTo(GroupMenuModel::class, 'group_menu_id');
    }
}
