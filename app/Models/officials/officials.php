<?php

namespace App\Models\officials;

use App\Models\menu\MenuModel;
use App\Models\menu\SubMenuModel;
use App\Models\sidebar\SidebarModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class officials extends Model
{
    use HasFactory;
    protected $table = 'officials';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'offificial_name',
        'designation',
        'bcs',
        'bcsid',
        'office_phone',
        'home_phone',
        'fax',
        'mobile',
        'email',
        'home_district',
        'joining_date',
        'page_url',
        'image',
    ];
    // Optionally, define casts for data types
    protected $casts = [
        'joining_date' => 'date',
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
