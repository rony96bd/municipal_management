<?php

namespace App\Models\page;

use App\Models\menu\MenuModel;
use App\Models\menu\SubMenuModel;
use App\Models\sidebar\SidebarModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class createpage extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('public_search_corpus'));
        static::deleted(fn () => Cache::forget('public_search_corpus'));
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages'; // Default assumed table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['page_name', 'page_url', 'page_data', 'file_path'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

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
