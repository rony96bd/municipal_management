<?php

namespace Municipal\Attestation\Models;

use Illuminate\Database\Eloquent\Model;

class AttestationSignatory extends Model
{
    protected $table = 'attestation_signatories';

    protected $fillable = [
        'preset_key',
        'name',
        'designation',
        'office_line',
        'extra_line',
        'signature_image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
