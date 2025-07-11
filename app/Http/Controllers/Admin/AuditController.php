<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DataTables\AuditDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexAuditRequest;

class AuditController extends Controller
{
    public function index(AuditDataTable $dataTable, IndexAuditRequest $request)
    {

        return $dataTable
            ->render('admin.audits.index', [
                'startDate' => $request->get('startDate'),
                'endDate' => $request->get('endDate'),
            ]);
    }
}
