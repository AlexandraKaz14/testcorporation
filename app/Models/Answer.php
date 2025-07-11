<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Answer extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use HasAudit;

    protected $fillable = [
        'question_id',
        'text',
        'number',
        'picture',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
}
