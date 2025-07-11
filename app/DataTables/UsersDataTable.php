<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('name', function (User $user) {
                $class = $user->trashed() ? 'nav-link disabled' : 'nav-link active';

                return view('partial.a', [
                    'atributes' => [
                        'class' => $class,
                    ],
                    'url' => route('admin.users.show', $user),
                    'text' => $user->name,
                ]);
            })
            ->editColumn('status', function (User $user) {
                return view('admin.users.datatable.status', compact('user'));
            })
            ->editColumn('role', function (User $user) {
                return __('common.' . $user->role);
            })
            ->editColumn('updated_at', function (User $user) {
                return $user->updated_at->format('Y-m-d H:i:s');
            })
            ->editColumn('created_at', function (User $user) {
                return $user->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function (User $user) {
                return view('admin.users.datatable.actions', compact('user'));
            })
            ->addColumn('tests', function (User $user) {
                return view('partial.tests_user', compact('user'));
            })
            ->rawColumns(['status', 'action', 'name, tests'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        $dateRange = request()
            ->get('daterange', '');
        $startDate = explode(' - ', $dateRange)[0] ?: '2024-01-01';
        $endDate = explode(' - ', $dateRange)[1] ?? now()->format('Y-m-d');
        $endDate .= ' 23:59:59.999';
        $query = User::query();
        $query->where('created_at', '<=', $endDate);
        $query->where('created_at', '>=', $startDate);

        $statuses = $this->request->get('statuses');
        if ($statuses) {
            $query->whereIn('status', $statuses);
        }
        $roles = $this->request->get('roles');
        if ($roles) {
            $query->whereIn('role', $roles);
        }

        $deletedStatuses = $this->request->get('deletedStatuses');
        if (($deletedStatuses
                && in_array(User::DELETED_STATUS_LIVE, $deletedStatuses, true)
                && in_array(User::DELETED_STATUS_TRASHED, $deletedStatuses, true))
            || !$deletedStatuses) {
            $query->withTrashed();
        } elseif ($deletedStatuses
            && in_array(User::DELETED_STATUS_TRASHED, $deletedStatuses, true)) {
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
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            Column::make('id')->title(__('common.id')),
            Column::make('name')->title(__('common.name')),
            Column::make('email')->title(__('common.email')),
            Column::make('role')->title(__('common.role')),
            Column::make('status')->title(__('common.status')),
            Column::make('tests')->title(__('common.tests total/active'))
                ->width(150)
                ->addClass('text-center'),
            Column::make('created_at')->title(__('common.created_at')),
            Column::computed('action')->title(__('common.actions'))
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }
}
