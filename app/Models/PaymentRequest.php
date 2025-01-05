<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentRequest extends Model
{
    use HasUuids;

    protected $fillable = [
        'payment_category_id',
        'description',
        'price',
        'file_id',
        'sheba_number',
        'user_id',
        'status',
        'comments',
    ];

    const STATUS = [
        'pending' => 1,
        'approved' => 2,
        'rejected' => 3,
        'paid' => 4,
    ];

    const CHANGEABLE_STATUS = [
        'approved' => self::STATUS['approved'],
        'rejected' => self::STATUS['rejected'],
    ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => array_search($value, self::STATUS),
            set: fn(string $value) => self::STATUS[$value]
        );
    }

    protected function comments(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function paymentCategory(): BelongsTo
    {
        return $this->belongsTo(PaymentCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', self::STATUS['approved']);
    }
}
