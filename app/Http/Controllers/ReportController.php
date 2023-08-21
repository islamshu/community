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

            // Set the timezone explicitly
            $now->setTimezone('Asia/Riyadh'); // Replace with your timezone

            switch ($filter) {
                case 'today':
                    $usersQuery->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $usersQuery->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $usersQuery->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'this_month':
                    $usersQuery->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
                    break;
                case 'all':
                    // No additional filtering needed
                    break;
            }
        }

        $usersQuery->where('is_paid', 0);

        $users = $usersQuery->get();
        return view('dashboard.reports.unpaid', compact('users','request'));
    }
}
