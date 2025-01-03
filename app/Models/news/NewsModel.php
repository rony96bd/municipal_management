<?php

namespace App\Models\news;

use App\Models\menu\MenuModel;
use App\Models\menu\SubMenuModel;
use App\Models\sidebar\SidebarModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it follows Laravel naming conventions)
    protected $table = 'news';

    // Specify the attributes that are mass assignable
    protected $fillable = [
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
