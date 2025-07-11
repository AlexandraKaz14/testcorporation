<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Result extends Model implements Auditable
{
    use HasFactory;
    use HasAudit;

    protected $fillable = [
        'test_id',
        'condition',
        'text',
        'is_default',
        'number',
    ];

    protected $attributes = [
        'is_default' => false,
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function variables()
    {
        return $this->belongsToMany(Variable::class);

    }
}
