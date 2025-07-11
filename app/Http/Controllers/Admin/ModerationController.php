<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DataTables\ModerationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexModerationRequest;
use App\Http\Requests\ModerationRequest;
use App\Models\Moderation;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class ModerationController extends Controller
{
    public function index(ModerationDataTable $dataTable, IndexModerationRequest $request)
    {
        $this->authorize('viewAny', Moderation::class);
        return $dataTable
            ->render(
                'admin.moderations.index',
                [
                    'startDate' => $request->get('startDate'),
                    'endDate' => $request->get('endDate'),
                ]
            );
    }

    public function approved(Moderation $moderation)
    {
        $this->authorize('view', $moderation);

        DB::transaction(function () use ($moderation) {
            $moderation->update([
                'moderator_id' => auth()
                    ->id(),
                'moderation_status' => Moderation::MODERATION_STATUS_APPROVED,
                'rejection_reason' => null,
                'moderation_at' => now(),
            ]);
            Test::where('id', $moderation->test->id)->update([
                'status' => Test::STATUS_ACTIVE,
            ]);
        });

        return redirect()->back()
            ->withSuccess('Модерация пройдена, тест успешно опубликован, уведомление отправлено автору теста');
    }

    public function rejected(Moderation $moderation, ModerationRequest $request)
    {
        $this->authorize('view', $moderation);

        $data = $request->validated();
        DB::transaction(function () use ($moderation, $data) {
            $moderation->update([
                'moderator_id' => auth()
                    ->id(),
                'moderation_status' => Moderation::MODERATION_STATUS_REJECTED,
                'rejection_reason' => $data['rejection_reason'],
                'moderation_at' => now(),
            ]);
            Test::where('id', $moderation->test->id)->update([
                'status' => Test::STATUS_DRAFT,
            ]);
        });

        return redirect()->route('admin.moderations.index', $moderation)
            ->withSuccess('Модерация теста не пройдена, отправлено уведомление автору теста');
    }
}
