<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Models\Audit;

class CustomAudit extends Audit
{
    use HasFactory;

    public const EVENT_CREATED = 'created';

    public const EVENT_UPDATED = 'updated';

    public const EVENT_DELETED = 'deleted';

    public const EVENT_RESTORED = 'restored';

    public const EVENTS = [
        self::EVENT_CREATED,
        self::EVENT_UPDATED,
        self::EVENT_DELETED,
        self::EVENT_RESTORED,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
