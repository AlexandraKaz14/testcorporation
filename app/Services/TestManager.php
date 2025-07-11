<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Result;
use App\Models\Tag;
use App\Models\Test;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestManager
{
    protected $resultManager;

    public function __construct(ResultManager $resultManager)
    {
        $this->resultManager = $resultManager;
    }

    //    public function upsertTest(Test $test, array $data): Test
    //    {
    //        $exists = $test->exists;
    //        $test->fill($data);
    //        DB::transaction(function () use ($exists, $test, $data) {
    //            $this->uploadImage($test, $data['picture'] ?? null, 'picture');
    //            $this->uploadImage($test, $data['background_image'] ?? null, 'background_image');
    //            $test->save();
    //            if (!$exists) {
    //                $this->resultManager->upsertResult(new Result(), [
    //                    'text' => 'Результат не определен',
    //                    'condition' => 'true',
    //                    'test_id' => $test->id,
    //                    'is_default' => true,
    //                ]);
    //            }
    //            $this->syncCategories($test, $data['categories']);
    //            $this->syncTags($test, $data['tags']);
    //        });
    //
    //        return $test;
    //    }

    public function upsertTest(Test $test, array $data): Test
    {
        $exists = $test->exists;
        $test->fill($data);
        DB::transaction(function () use ($exists, $test, $data) {
            if (!empty($data['delete_background_image'])) {
                $this->deleteImage($test, 'background_image');
                $test->background_image = null;
            } else {
                $this->uploadImage($test, $data['background_image'] ?? null, 'background_image');
            }
            $this->uploadImage($test, $data['picture'] ?? null, 'picture');
            $test->save();

            if (!$exists) {
                $this->resultManager->upsertResult(new Result(), [
                    'text' => 'Результат не определен',
                    'condition' => 'true',
                    'test_id' => $test->id,
                    'is_default' => true,
                ]);
            }
            $this->syncCategories($test, $data['categories']);
            $this->syncTags($test, $data['tags']);
        });

        return $test;
    }

    public function getQuestions(Test $test, bool $showDeletedQuestions = false)
    {
        return $test
            ->questions()
            ->when($showDeletedQuestions, function ($q) {
                return $q->onlyTrashed();
            })
            ->orderBy('number')
            ->get();
    }

    public function getVariables(Test $test, bool $showDeletedVariables = false)
    {
        return $test
            ->variables()
            ->when($showDeletedVariables, function ($q) {
                return $q->onlyTrashed();
            })
            ->orderBy('name')
            ->get();
    }

    public function getResults(Test $test)
    {
        return $test
            ->results()
            ->orderByRaw('is_default, number')
            ->get();
    }

    protected function uploadImage(Test $test, ?UploadedFile $picture, string $field): void
    {
        if ($picture) {
            if ($test->{$field} && Storage::disk()->exists($test->{$field})) {
                Storage::disk()->delete($test->{$field});
            }
            $test->{$field} = Storage::disk()->put('/pictures', $picture);
        }
    }

    protected function syncCategories(Test $test, array $categories): void
    {
        $test->categories()
            ->sync($categories);
    }

    protected function syncTags(Test $test, array $tags): void
    {
        $tagList = [];
        foreach ($tags as $tagInput) {
            $tagList[] = Tag::firstOrCreate([
                'name' => $tagInput,
            ]);
        }
        $test->tags()
            ->sync(collect($tagList)->pluck('id'));
    }

    protected function deleteImage(Test $test, string $field): void
    {
        if ($test->{$field} && Storage::disk()->exists($test->{$field})) {
            Storage::disk()->delete($test->{$field});
        }
    }
}
