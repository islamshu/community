<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function unpaid(Request $request){
        $usersQuery = User::query();

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $now = Carbon::now();

            switch ($filter) {
             
                case 'today':
                    $usersQuery->where('is_paid',0)->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $usersQuery->where('is_paid',0)->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $usersQuery->where('is_paid',0)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $usersQuery->where('is_paid',0)->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
                    break;
                    case 'all':
                        $usersQuery->where('is_paid',0);
                        break;
            }
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = Carbon::parse($request->input('from_date'));
            $toDate = Carbon::parse($request->input('to_date'));

            $usersQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $users = $usersQuery->orderby('id','desc')->get();

        return view('dashboard.reports.unpaid', compact('users','request'));
    }
}
