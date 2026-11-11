<?php

namespace Municipal\Attestation\Models;

use Illuminate\Database\Eloquent\Model;

class AttestationSequence extends Model
{
    protected $table = 'attestation_sequences';

    protected $fillable = [
        'attestation_type_id',
        'year',
        'last_number',
    ];

    protected $casts = [
        'year'        => 'integer',
        'last_number' => 'integer',
    ];
}
