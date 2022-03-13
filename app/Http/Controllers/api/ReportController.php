<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BasicReportRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function basic_report(BasicReportRequest $request)
    {
        $starting_date = $request->starting_date;
        $ending_date = $request->ending_date;

        $transactions = Transaction::whereDate('created_at', '>=', $starting_date)
                                    ->whereDate('created_at', '<=', $ending_date)
                                    ->get();

        $filtered_transactions['period']['from '] = $starting_date;
        $filtered_transactions['period']['to '] = $ending_date;
        $filtered_transactions['paid_amount'] = $transactions->where('status', 'paid')->sum('amount');
        $filtered_transactions['outstanding_amount'] = $transactions->where('status', 'outstanding')->sum('amount');
        $filtered_transactions['overdue_amount'] = $transactions->where('status', 'overdue')->sum('amount');
        return $filtered_transactions;
    }

    public function monthly_report(BasicReportRequest $request)
    {
        //
    }
}
