<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Moderation extends Model implements Auditable
{
    use HasFactory;
    use HasAudit;

    public const MODERATION_STATUS_PENDING = 'pending';

    public const MODERATION_STATUS_APPROVED = 'approved';

    public const MODERATION_STATUS_REJECTED = 'rejected';

    public const MODERATION_STATUSES = [
        self::MODERATION_STATUS_PENDING,
        self::MODERATION_STATUS_APPROVED,
        self::MODERATION_STATUS_REJECTED,
    ];

    protected $table = 'moderation_tests';

    protected $fillable = [
        'test_id',
        'moderator_id',
        'moderation_status',
        'rejection_reason',
        'moderation_at',
    ];

    protected $casts = [
        'moderation_at' => 'datetime',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function isRejection(): bool
    {
        return $this->moderation_status === self::MODERATION_STATUS_REJECTED;
    }

    public function isPending(): bool
    {
        return $this->moderation_status === self::MODERATION_STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->moderation_status === self::MODERATION_STATUS_APPROVED;
    }
}
