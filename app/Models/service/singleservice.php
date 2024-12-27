<?php

namespace App\Models\service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class singleservice extends Model
{
    use HasFactory;

    protected $table = 'single_service';

    protected $fillable = [
        'service_id',
        'service_item_name',
        'service_item_description',
        'page_url',
    ];

    public function service()
    {
        return $this->belongsTo(services::class, 'service_id', 'service_id');
    }
}
