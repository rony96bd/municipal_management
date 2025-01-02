<?php

namespace App\Models\Service;

use App\Models\sidebar\SidebarModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class SingleService extends Model
{
    use HasFactory;

    protected $table = 'single_services';

    protected $fillable = [
        'service_id',
        'service_item_name',
        'service_item_description',
        'page_url',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
    public function sidebar()
    {
        return $this->belongsTo(SidebarModel::class);
    }
}
