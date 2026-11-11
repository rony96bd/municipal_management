<?php

namespace Municipal\Attestation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Attestation extends Model
{
    use SoftDeletes;

    protected $table = 'attestations';

    protected $fillable = [
        'application_id',
        'attestation_type_id',
        'memo_no',
        'year',
        'serial',
        'issue_date',
        'verification_code',
        'snapshot',
        'subject_name',
        'id_no',
        'fee',
        'payment_status',
        'paid_amount',
        'receipt_no',
        'paid_at',
        'issued_by',
        'printed_count',
        'last_printed_at',
        'handed_over_at',
        'handed_over_to',
        'is_cancelled',
        'cancel_reason',
    ];

    protected $casts = [
        'snapshot'        => 'array',
        'issue_date'      => 'date',
        'fee'             => 'decimal:2',
        'paid_amount'     => 'decimal:2',
        'paid_at'         => 'datetime',
        'last_printed_at' => 'datetime',
        'handed_over_at'  => 'datetime',
        'is_cancelled'    => 'boolean',
        'printed_count'   => 'integer',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(AttestationApplication::class, 'application_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AttestationType::class, 'attestation_type_id');
    }

    public function issuer(): BelongsTo
    {
        $userModel = config('attestation.user_model', \App\Models\User::class);
        return $this->belongsTo($userModel, 'issued_by');
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(AttestationLog::class, 'loggable')->latest();
    }

    public function scopeByVerificationCode($query, string $code)
    {
        return $query->where('verification_code', $code);
    }

    public static function generateVerificationCode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        do {
            $part1 = '';
            $part2 = '';
            for ($i = 0; $i < 4; $i++) {
                $part1 .= $chars[random_int(0, strlen($chars) - 1)];
                $part2 .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $code = "AP-{$part1}-{$part2}";
        } while (static::where('verification_code', $code)->exists());

        return $code;
    }
}
