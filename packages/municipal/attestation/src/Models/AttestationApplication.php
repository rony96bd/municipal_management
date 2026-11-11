<?php

namespace Municipal\Attestation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Municipal\Attestation\Enums\ApplicationStatus;

class AttestationApplication extends Model
{
    use SoftDeletes;

    protected $table = 'attestation_applications';

    protected $fillable = [
        'tracking_no',
        'attestation_type_id',
        'applicant_name',
        'mobile',
        'id_type',
        'id_no',
        'father_name',
        'mother_name',
        'spouse_name',
        'ward_no',
        'holding_no',
        'mohalla',
        'upazila',
        'district',
        'data',
        'attachments',
        'status',
        'reject_reason',
        'admin_note',
        'fee',
        'payment_status',
        'paid_amount',
        'receipt_no',
        'paid_at',
        'created_by',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'data'        => 'array',
        'attachments' => 'array',
        'status'      => ApplicationStatus::class,
        'fee'         => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'paid_at'     => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(AttestationType::class, 'attestation_type_id');
    }

    public function attestation(): HasOne
    {
        return $this->hasOne(Attestation::class, 'application_id');
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(AttestationLog::class, 'loggable')->latest();
    }

    public function creator(): BelongsTo
    {
        $userModel = config('attestation.user_model', \App\Models\User::class);
        return $this->belongsTo($userModel, 'created_by');
    }

    public function reviewer(): BelongsTo
    {
        $userModel = config('attestation.user_model', \App\Models\User::class);
        return $this->belongsTo($userModel, 'reviewed_by');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status instanceof ApplicationStatus ? $status->value : $status);
    }

    public static function generateTrackingNo(): string
    {
        do {
            $tracking = 'ATT-' . date('Y') . '-' . str_pad((string) random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (static::where('tracking_no', $tracking)->exists());

        return $tracking;
    }

    public function idTypeLabel(): string
    {
        return match ($this->id_type) {
            'birth_reg' => 'জন্ম নিবন্ধন নম্বর',
            'death_reg' => 'মৃত্যু নিবন্ধন নম্বর',
            default     => 'জাতীয় পরিচয়পত্র নম্বর',
        };
    }
}
