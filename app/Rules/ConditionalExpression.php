<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Variable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class ConditionalExpression implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $expressionLanguage = new ExpressionLanguage();
        $testId = request()
            ->get('test_id');
        $validVariables = Variable::where('test_id', $testId)->pluck('name')->toArray();

        try {
            $expressionLanguage->lint($value, $validVariables);
        } catch (SyntaxError $error) {
            $fail($error->getMessage());
        }
    }
}
