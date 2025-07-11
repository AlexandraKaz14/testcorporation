<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('title', function (Category $category) {
                return '<a href="' . route('admin.categories.show', $category) . '" >' . $category->title . '</a>';
            })
            ->addColumn('action', function (Category $category) {
                return view('admin.categories.datatable.actions', compact('category'));
            })
            ->editColumn('created_at', function (Category $category) {
                return $category->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function (Category $category) {
                return $category->updated_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['title', 'action'])
            ->setRowId('id');

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
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
            ->setTableId('categories-table')
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
            Column::make('title')->title(__('common.title'))->addClass('text-center'),
            Column::make('created_at')->title(__('common.created_at'))->addClass('text-center'),
            Column::computed('action')->title(__('common.actions'))
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }
}
