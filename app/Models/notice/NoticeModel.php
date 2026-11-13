<?php

namespace App\Models\notice;

use App\Models\menu\MenuModel;
use App\Models\menu\SubMenuModel;
use App\Models\sidebar\SidebarModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class NoticeModel extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('public_search_corpus'));
        static::deleted(fn () => Cache::forget('public_search_corpus'));
    }

    // Define the table associated with the model (optional if it follows Laravel naming conventions)
    protected $table = 'notices';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'page_url',
        'topic',
        'description',
        'file_path',
    ];

    public function sidebar()
    {
        return $this->belongsTo(SidebarModel::class);
    }
    public function menus()
    {
        return $this->belongsTo(MenuModel::class);
    }
    public function submenus()
    {
        return $this->belongsTo(SubMenuModel::class);
    }
}
