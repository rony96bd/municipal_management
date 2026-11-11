<?php

namespace Municipal\Attestation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AttestationLog extends Model
{
    protected $table = 'attestation_logs';

    protected $fillable = [
        'loggable_type',
        'loggable_id',
        'action',
        'changes',
        'user_id',
        'ip',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        $userModel = config('attestation.user_model', \App\Models\User::class);
        return $this->belongsTo($userModel, 'user_id');
    }

    public static function record(Model $model, string $action, array $changes = []): self
    {
        return static::create([
            'loggable_type' => get_class($model),
            'loggable_id'   => $model->getKey(),
            'action'        => $action,
            'changes'       => $changes,
            'user_id'       => auth()->id(),
            'ip'            => request()?->ip(),
        ]);
    }
}
