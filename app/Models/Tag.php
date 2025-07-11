<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Tag extends Model implements Auditable
{
    use HasFactory;
    use HasAudit;

    protected $fillable = [
        'name',
    ];

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'tag_tests');
    }
}
