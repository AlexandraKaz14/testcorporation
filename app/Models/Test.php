<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\UserRoleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Test extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use HasAudit;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_MODERATION = 'moderation';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_ACTIVE,
        self::STATUS_MODERATION,
    ];

    public const DELETED_STATUSES = [
        self::STATUS_UNDELETED,
        self::STATUS_DELETED,
    ];

    public const STATUS_DELETED = 'deleted';

    public const STATUS_UNDELETED = 'undeleted';

    protected $fillable = [
        'user_id',
        'theme_id',
        'title',
        'description',
        'status',
        'slug',
        'background_image',
        'picture',
        'meta_keywords',
        'meta_description',
    ];

    protected $attributes = [
        'status' => self::STATUS_DRAFT,
    ];

    protected static $enableGlobalScope = true;

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_tests');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_tests');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('number');
    }

    public function variables()
    {
        return $this->hasMany(Variable::class);

    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function takings()
    {
        return $this->hasMany(TakingTest::class, 'test_id');
    }

    public function takingsSubDay()
    {
        return $this->hasMany(TakingTest::class, 'test_id')->where('taking_tests.created_at', '>=', now()->subDay());
    }

    public function takingsSubWeek()
    {
        return $this->hasMany(TakingTest::class, 'test_id')->where('taking_tests.created_at', '>=', now()->subWeek());
    }

    public function takingsSubMonth()
    {
        return $this->hasMany(TakingTest::class, 'test_id')->where('taking_tests.created_at', '>=', now()->subMonth());
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isModeration(): bool
    {
        return $this->status === self::STATUS_MODERATION;
    }

    public function moderation()
    {
        return $this->hasOne(Moderation::class);
    }

    public static function disableGlobalScope()
    {
        static::$enableGlobalScope = false;
    }

    protected static function booted()
    {
        if (static::$enableGlobalScope) {
            static::addGlobalScope(new UserRoleScope());
        }
    }
}
