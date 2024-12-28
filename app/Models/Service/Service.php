<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'service_id';
    protected $fillable = [
        'service_id',
        'service_name',
        'service_description',
        'page_url',
    ];

    public function singleServices()
    {
        return $this->hasMany(SingleService::class, 'service_id');
    }
}
