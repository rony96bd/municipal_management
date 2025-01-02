<?php

namespace App\Models\page;

use App\Models\sidebar\SidebarModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class createpage extends Model
{
    use HasFactory;

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
    protected $fillable = ['page_name', 'page_url', 'page_data'];

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
}
