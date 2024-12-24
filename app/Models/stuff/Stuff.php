<?php

namespace App\Models\stuff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stuff extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stuffs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stuff_name',
        'designation',
        'office_phone',
        'home_phone',
        'mobile',
        'email',
        'home_district',
        'joining_date',
        'page_url',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'joining_date' => 'date',
    ];
}
