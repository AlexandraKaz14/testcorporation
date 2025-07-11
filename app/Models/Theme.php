<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Theme extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use HasAudit;

    protected $fillable = [
        'title',
        'css_style',
    ];
}
