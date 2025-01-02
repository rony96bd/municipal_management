<?php

namespace App\Models\representatives;

use App\Models\sidebar\SidebarModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class representatives extends Model
{
    use HasFactory;
    protected $table = 'representatives';
    protected $fillable = [
        'name',
        'designation',
        'word_number',
        'office_phone',
        'home_phone',
        'fax',
        'mobile',
        'email',
        'home_district',
        'page_url',
        'elected_type',
        'presentaddress',
        'permanentaddress',
        'image',
    ];

    public function sidebar()
    {
        return $this->belongsTo(SidebarModel::class);
    }
}
