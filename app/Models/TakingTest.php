<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class TakingTest extends Model implements Auditable
{
    use HasFactory;
    use HasAudit;

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
