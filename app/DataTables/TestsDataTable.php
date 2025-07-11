<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\Test;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TestsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('title', function (Test $test) {
                $class = $test->trashed() ? 'nav-link disabled' : 'nav-link active';

                return view('admin.tests.datatable.title', compact('test', 'class'));

            })
            ->editColumn('picture', function (Test $test) {
                return view('admin.tests.datatable.pictures', compact('test'));
            })
            ->editColumn('created_at', function (Test $test) {
                return $test->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('description', function (Test $test) {
                return mb_strlen($test->description) > 23 ?
                    mb_substr($test->description, 0, 20) . '...' :
                    $test->description;
            })
            ->addColumn('status', function (Test $test) {
                return view('admin.tests.datatable.status', compact('test'));
            })
            ->addColumn('count_question', function (Test $test) {
                return '<span class="badge badge-warning">' . $test->questions->count() . '</span>';

            })
            ->addColumn('action', function (Test $test) {
                return view('admin.tests.datatable.actions', compact('test'));
            })

            ->rawColumns(['picture', 'description', 'action', 'count_question'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Test $model): QueryBuilder
    {
        $dateRange = request()
            ->get('daterange', '');
        $startDate = explode(' - ', $dateRange)[0] ?: '2024-01-01';
        $endDate = explode(' - ', $dateRange)[1] ?? now()->format('Y-m-d');
        $endDate .= ' 23:59:59.999';
        $query = Test::query();
        $query->where('created_at', '<=', $endDate);
        $query->where('created_at', '>=', $startDate);

        $categories = $this->request->get('categories');
        $tags = $this->request->get('tags');
        $users = $this->request->get('users');
        $statuses = $this->request->get('statuses');

        if ($categories) {
            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('categories.id', $categories);
            });
        }
        if ($tags) {
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('tags.id', $tags);
            });
        }
        if ($users) {
            $query->whereIn('user_id', $users);
        }
        if ($statuses) {
            $query->whereIn('status', $statuses);
        }

        $deletedStatuses = $this->request->get('deletedStatuses');
        if (($deletedStatuses
                && in_array(Test::STATUS_UNDELETED, $deletedStatuses, true)
                && in_array(Test::STATUS_DELETED, $deletedStatuses, true))
            || !$deletedStatuses) {
            $query->withTrashed();
        } elseif ($deletedStatuses
            && in_array(Test::STATUS_DELETED, $deletedStatuses, true)) {
            $query->onlyTrashed();
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
            ->setTableId('tests-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->pageLength(25)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('common.id'))->addClass('text-center'),
            Column::make('title')->title(__('common.title')),
            Column::make('description')->title(__('common.description')),
            Column::make('picture')->title(__('common.picture'))->addClass('text-center'),
            Column::make('status')->title(__('common.status'))->addClass('text-center'),
            Column::make('created_at')->title(__('common.created_at'))->addClass('text-center'),
            Column::make('count_question')->title(__('common.count questions'))->addClass('text-center'),
            Column::computed('action')->title(__('common.actions'))
                ->exportable(false)
                ->printable(false)
                ->width(200),
        ];
    }
}
