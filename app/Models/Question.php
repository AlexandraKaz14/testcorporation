<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Question extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use HasAudit;

    public const TYPE_ONLY_ANSWER = 'only';

    public const TYPES_ANSWERS = [
        self::TYPE_ONLY_ANSWER,
    ];

    protected $fillable = [
        'test_id',
        'text',
        'type',
        'picture',
        'number',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
