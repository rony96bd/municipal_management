<?php

namespace App\Models\service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
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
        return $this->hasMany(singleservice::class, 'service_id', 'service_id');
    }
}
