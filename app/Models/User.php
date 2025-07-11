<?php

declare(strict_types=1);

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use CanResetPassword;
    use HasAudit;

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_MODERATOR,
        self::ROLE_AUTHOR,
    ];

    public const ROLE_ADMIN = 'admin';

    public const ROLE_MODERATOR = 'moderator';

    public const ROLE_AUTHOR = 'author';

    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_BLOCKED,
    ];

    public const STATUS_ACTIVE = 'active';

    public const STATUS_BLOCKED = 'blocked';

    public const DELETED_STATUSES = [
        self::DELETED_STATUS_LIVE,
        self::DELETED_STATUS_TRASHED,
    ];

    public const DELETED_STATUS_LIVE = 'live';

    public const DELETED_STATUS_TRASHED = 'trashed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'email_verified_at',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAuthor(): bool
    {
        return $this->role === self::ROLE_AUTHOR;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
