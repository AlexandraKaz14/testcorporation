<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Answer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnswerManager
{
    public function upsertAnswer(Answer $answer, array $data): Answer
    {

        $answer->fill($data);
        if (!$answer->exists) {
            $answer->number = $answer->question->answers()
                ->count() + 1;
        }

        DB::transaction(function () use ($answer, $data) {
            $this->uploadImage($answer, $data['picture'] ?? null);
            $answer->save();
        });

        return $answer;

    }

    public function getReactions(Answer $answer)
    {
        return $answer
            ->reactions()
            ->orderBy('id')
            ->get();
    }

    protected function uploadImage(Answer $answer, ?UploadedFile $picture): void
    {
        if ($picture) {
            if ($answer->picture && Storage::disk()->exists($answer->picture)) {
                Storage::disk()->delete($answer->picture);
            }
            $answer->picture = Storage::disk()->put('/pictures', $picture);
        }
    }
}
