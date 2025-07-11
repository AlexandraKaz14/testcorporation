<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\CustomAudit;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AuditDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('user_type', function (CustomAudit $audit) {
                return view('admin.audits.datatable.type_user', compact('audit'));
            })
            ->editColumn('user_id', function (CustomAudit $audit) {
                return isset($audit->user_id) ?
                    '<a href="' . route('admin.users.show', $audit->user_id) . '" >' . $audit->user->name . '</a>'
                    : '---';
            })
            ->editColumn('event', function (CustomAudit $audit) {
                return view('admin.audits.datatable.events', compact('audit'));
            })
            ->editColumn('old_values', function (CustomAudit $audit) {
                $old_values = collect($audit->old_values)
                    ->map(fn ($value, $key) => "{$key}: {$value}")
                    ->implode(', ');
                if (empty($old_values)) {
                    return '---';
                }

                return view('admin.audits.datatable.old_values', compact('old_values'));

            })
            ->editColumn('new_values', function (CustomAudit $audit) {
                $new_values = collect($audit->new_values)
                    ->map(fn ($value, $key) => "{$key}: {$value}")
                    ->implode(', ');
                if (empty($new_values)) {
                    return '---';
                }

                return view('admin.audits.datatable.new_values', compact('new_values'));
            })
            ->editColumn('url', function (CustomAudit $audit) {
                return view('admin.audits.datatable.copy_url', compact('audit'));
            })
            ->editColumn('ip_address', function (CustomAudit $audit) {
                return $audit->ip_address;
            })
            ->editColumn('created_at', function (CustomAudit $audit) {
                return $audit->created_at->format('Y-m-d H:i:s');
            })

            ->rawColumns(['new_values', 'old_values', 'user_id', 'url', 'ip_address'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CustomAudit $model): QueryBuilder
    {
        $dateRange = request()
            ->get('daterange', '');
        $startDate = explode(' - ', $dateRange)[0] ?: '2024-01-01';
        $endDate = explode(' - ', $dateRange)[1] ?? now()->format('Y-m-d');
        $endDate .= ' 23:59:59.999';
        $query = CustomAudit::query();
        $query->where('created_at', '<=', $endDate);
        $query->where('created_at', '>=', $startDate);

        $events = $this->request->get('events');
        if ($events) {
            $query->whereIn('event', $events);
        }
        $models = $this->request->get('models');
        if ($models) {
            $query->whereIn('auditable_type', $models);
        }
        $users = $this->request->get('users');
        if (!empty($users)) {
            $query->whereIn('user_id', $users);
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
            ->setTableId('audit-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->pageLength(25)
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('user_type')->title(__('common.user_type'))->width(50),
            Column::make('user_id')->title(__('common.user')),
            Column::make('event')->title(__('common.event')),
            Column::make('auditable_type')->title(__('common.auditable_type')),
            Column::make('old_values')->title(__('common.old_values'))->width(50),
            Column::make('new_values')->title(__('common.new_values'))->width(50),
            Column::make('url'),
            Column::make('ip_address')->title(__('common.ip_address')),
            Column::make('created_at')->title(__('common.created_at')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Audit_' . date('YmdHis');
    }
}
