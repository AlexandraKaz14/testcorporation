<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Group;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GroupManager
{
    public function upsertGroup(Group $group, array $data): Group
    {
        $group->fill($data);
        DB::transaction(function () use ($group, $data) {
            $this->uploadImage($group, $data['picture'] ?? null, 'picture');
            $group->save();
            $this->syncTests($group, $data['tests']);
        });

        return $group;
    }

    protected function uploadImage(Group $group, ?UploadedFile $picture, string $field): void
    {
        if ($picture) {
            if ($group->picture && Storage::disk()->exists($group->picture)) {
                Storage::disk()->delete($group->picture);
            }
            $group->picture = Storage::disk()->put('/pictures', $picture);
        }
    }

    protected function syncTests(Group $group, array $tests): void
    {
        $group->tests()
            ->sync($tests);
    }
}
