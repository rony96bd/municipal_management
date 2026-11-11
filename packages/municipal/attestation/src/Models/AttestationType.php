<?php

namespace Municipal\Attestation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttestationType extends Model
{
    use SoftDeletes;

    protected $table = 'attestation_types';

    protected $fillable = [
        'name',
        'slug',
        'memo_name',
        'description',
        'subject_status',
        'person_fields',
        'fields',
        'body_template',
        'closing_line',
        'signatories',
        'print_layout',
        'print_options',
        'fee',
        'is_public',
        'is_active',
        'order',
    ];

    protected $casts = [
        'person_fields' => 'array',
        'fields'        => 'array',
        'signatories'   => 'array',
        'print_options' => 'array',
        'is_public'     => 'boolean',
        'is_active'     => 'boolean',
        'fee'           => 'decimal:2',
        'order'         => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_active', true)->where('is_public', true);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(AttestationApplication::class, 'attestation_type_id');
    }

    public function attestations(): HasMany
    {
        return $this->hasMany(Attestation::class, 'attestation_type_id');
    }

    public static function standardPersonFields(): array
    {
        $holderLabel = config('attestation.organization.holder_label', 'পৌর');
        return [
            'applicant_name' => 'নাম',
            'id_no'          => 'জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন / মৃত্যু নিবন্ধন নম্বর',
            'father_name'    => 'পিতার নাম',
            'mother_name'    => 'মাতার নাম',
            'spouse_name'    => 'স্বামী / স্ত্রীর নাম',
            'ward_no'        => "{$holderLabel} ওয়ার্ড নম্বর",
            'holding_no'     => 'হোল্ডিং নম্বর',
            'mohalla'        => 'মহল্লা / গ্রাম',
            'upazila'        => 'উপজেলা',
            'district'       => 'জেলা',
            'mobile'         => 'মোবাইল নম্বর',
        ];
    }
}
