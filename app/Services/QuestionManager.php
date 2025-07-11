<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Question;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionManager
{
    public function upsertQuestion(Question $question, array $data): Question
    {
        $question->fill($data);
        if (!$question->exists) {
            $question->number = $question->test->questions()
                ->count() + 1;
        }

        DB::transaction(function () use ($question, $data) {
            $this->uploadImage($question, $data['picture'] ?? null);
            $question->save();
        });

        return $question;
    }

    public function getAnswers(Question $question, bool $showDeletedAnswers = false)
    {
        return $question
            ->answers()
            ->when($showDeletedAnswers, function ($q) {
                return $q->onlyTrashed();
            })
            ->orderBy('number')
            ->get();
    }

    protected function uploadImage(Question $question, ?UploadedFile $picture): void
    {
        if ($picture) {
            if ($question->picture && Storage::disk()->exists($question->picture)) {
                Storage::disk()->delete($question->picture);
            }
            $question->picture = Storage::disk()->put('/pictures', $picture);
        }
    }
}
