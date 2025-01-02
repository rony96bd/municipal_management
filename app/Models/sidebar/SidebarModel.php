<?php

namespace App\Models\sidebar;

use App\Models\news\NewsModel;
use App\Models\notice\NoticeModel;
use App\Models\officials\officials;
use App\Models\representatives\representatives;
use App\Models\stuff\Stuff;
use App\Models\page\createpage;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SidebarModel extends Model
{
    protected $table = 'sidebars';
    protected $fillable = [
        'forigen_id',
        'forigen_type',  // Added to handle polymorphic relations
        'order',
        'gap',
        'sidebar_title',
        'link_text',
        'link_url',
        'tab',
    ];

    // Polymorphic relationship: this will refer to either 'officials', 'representatives', etc.
    public function forigen(): MorphTo
    {
        return $this->morphTo();
    }

    public function pages()
    {
        return $this->hasMany(createpage::class);
    }
    public function notices()
    {
        return $this->hasMany(NoticeModel::class);
    }
    public function news()
    {
        return $this->hasMany(NewsModel::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
