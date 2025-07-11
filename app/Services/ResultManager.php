<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Result;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ResultManager
{
    public function upsertResult(Result $result, array $data): Result
    {
        if ($result->is_default === true) {
            unset($data['condition']);
        }

        $result->fill($data);
        if (!$result->exists) {
            $result->number = $result->test->results()
                ->count() + 1;
        }

        DB::transaction(function () use ($result, $data) {
            $this->uploadImage($result, $data['picture'] ?? null);

            $expression = new ExpressionLanguage();
            $variables = $result->test->variables->pluck('name')
                ->toArray();
            $nodes = $expression->parse($result->condition, $variables)
                ->getNodes();
            $usedVariables = [];
            $this->f($nodes, $usedVariables);
            $usedVariables = array_keys($usedVariables);
            $usedVariables = array_intersect($variables, $usedVariables);
            $variableIds = $result->test->variables()
                ->whereIn('name', $usedVariables)
                ->get();
            $result->condition = $nodes->dump();
            $result->save();
            $result->variables()
                ->sync($variableIds);
        });

        return $result;
    }

    protected function uploadImage(Result $result, ?UploadedFile $picture): void
    {
        if ($picture) {
            if ($result->picture && Storage::disk()->exists($result->picture)) {
                Storage::disk()->delete($result->picture);
            }
            $result->picture = Storage::disk()->put('/pictures', $picture);
        }
    }

    private function f($root, array &$map): void
    {
        if (isset($root->nodes) && isset($root->nodes['left'])) {
            $this->f($root->nodes['left'], $map);
        }
        if (isset($root->nodes) && isset($root->nodes['right'])) {
            $this->f($root->nodes['right'], $map);
        }
        if (isset($root->attributes['name'])) {
            $map[$root->attributes['name']] = true;
        }
    }
}
