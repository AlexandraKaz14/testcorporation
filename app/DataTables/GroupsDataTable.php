<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GroupsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('title', function (Group $group) {
                return '<a href="' . route('admin.groups.show', $group) . '">' . $group->title . '</a>';
            })
            ->addColumn('description', function (Group $group) {
                return mb_strlen($group->description) > 23 ?
                    mb_substr($group->description, 0, 20) . '...' :
                    $group->description;
            })
            ->editColumn('picture', function (Group $group) {
                return view('admin.groups.datatable.pictures', compact('group'));
            })
            ->addColumn('count_tests', function (Group $group) {
                return '<span class="badge badge-warning">' . $group->tests()->count() . '</span>';

            })
            ->addColumn('action', function (Group $group) {
                return view('admin.groups.datatable.actions', compact('group'));
            })
            ->editColumn('created_at', function (Group $group) {
                return $group->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function (Group $group) {
                return $group->updated_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['title', 'description', 'picture', 'count_tests', 'action'])
            ->setRowId('id');

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Group $model): QueryBuilder
    {
        return $model->newQuery();
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
            ->setTableId('groups-table')
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
            Column::make('id')->title(__('common.id'))->addClass('text-left'),
            Column::make('title')->title(__('common.title'))->addClass('text-left'),
            Column::make('description')->title(__('common.description'))->addClass('text-left'),
            Column::make('picture')->title(__('common.cover'))->addClass('text-center'),
            Column::make('count_tests')->title(__('common.count tests'))->addClass('text-center'),
            Column::make('created_at')->title(__('common.created_at'))->addClass('text-center'),
            Column::computed('action')->title(__('common.actions'))
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-left'),
        ];
    }
}
