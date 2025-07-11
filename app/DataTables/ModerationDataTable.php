<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\Moderation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ModerationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('title', function (Moderation $moderation) {
                return '<a href="' . route('admin.tests.show', $moderation->test->id) . '">' . $moderation->test->title . '</a>';
            })

            ->addColumn('moderation_status', function (Moderation $moderation) {
                return view('admin.moderations.datatable.status', compact('moderation'));
            })

            ->addColumn('rejection_reason', function (Moderation $moderation) {
                return $moderation->rejection_reason ? $moderation->rejection_reason : '—';

            })
            ->addColumn('moderator', function (Moderation $moderation) {
                return $moderation->user
                    ? '<a href="' . route('admin.users.show', $moderation->user->id) . '">' . ($moderation->user->name) . '</a>'
                    : '—';
            })
            ->editColumn('moderation_at', function (Moderation $moderation) {
                return $moderation->moderation_at ? $moderation->moderation_at->format('Y-m-d H:i:s') : '—';
            })
            ->addColumn('action', function (Moderation $moderation) {
                return view('admin.moderations.datatable.actions', compact('moderation'));
            })
            ->editColumn('created_at', function (Moderation $moderation) {
                return $moderation->created_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['title', 'action', 'moderator', 'rejection_accepted', 'moderation_status', 'moderation_at'])
            ->setRowId('id');

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Moderation $model): QueryBuilder
    {
        $dateRange = request()
            ->get('daterange', '');
        $startDate = explode(' - ', $dateRange)[0] ?: '2025-01-01';
        $endDate = explode(' - ', $dateRange)[1] ?? now()->format('Y-m-d');
        $endDate .= ' 23:59:59.999';
        $query = Moderation::query();
        $query->where('created_at', '<=', $endDate);
        $query->where('created_at', '>=', $startDate);

        $statuses = $this->request->get('statuses');
        if ($statuses) {
            $query->whereIn('moderation_status', $statuses);
        }

        $moderators = $this->request->get('moderators');
        if ($moderators) {
            $moderators = array_map('intval', $moderators);
            $query->whereIn('moderator_id', $moderators);
        }

        $authors = $this->request->get('authors');
        if ($authors) {
            $authors = array_map('intval', $authors);
            $query->whereHas('test', function ($q) use ($authors) {
                $q->whereIn('user_id', $authors);
            });
        }
        return $this->applyScopes($query);

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->language([
                'url' => url('/datatables.ru.json'),
            ])
            ->setTableId('moderation_tests-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('common.id'))->addClass('text-center'),
            Column::make('title')->title(__('common.title test'))->addClass('text-center'),
            Column::make('moderation_status')->title(__('common.moderation status'))->addClass('text-center'),
            Column::make('rejection_reason')->title(__('common.reason for refusal'))->addClass('text-center'),
            Column::make('moderator')->title(__('common.moderator'))->addClass('text-center'),
            Column::make('moderation_at')->title(__('common.moderation_at'))->addClass('text-center'),
            Column::make('created_at')->title(__('common.created_at'))->addClass('text-center'),
            Column::computed('action')->title(__('common.actions'))
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }
}
