<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as HasAudit;
use OwenIt\Auditing\Contracts\Auditable;

class Reaction extends Model implements Auditable
{
    use HasFactory;
    use HasAudit;

    public const OPERATION_ADDITION = 'addition';

    public const OPERATION_SUBTRACTION = 'subtraction';

    public const OPERATION_MULTI = 'multiplication';

    public const OPERATION_DIVISION = 'division';

    public const OPERATIONS = [
        self::OPERATION_ADDITION => '+',
        self::OPERATION_SUBTRACTION => '-',
        self::OPERATION_MULTI => '*',
        self::OPERATION_DIVISION => '÷',
    ];

    protected $fillable = [
        'answer_id',
        'variable_id',
        'operation',
        'value',
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function variable()
    {
        return $this->belongsTo(Variable::class);
    }
}
