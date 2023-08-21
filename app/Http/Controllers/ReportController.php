<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function get_interested_modal(Request $request){
        return view('dashboard.reports.interestedModal')->with('user_id',$request->user_id)->with('selected_value',$request->selected_value);
    }
    public function get_negotiated_modal(Request $request){
        return view('dashboard.reports.negotiated_modal')->with('user_id',$request->user_id)->with('selected_value',$request->selected_value);
    }
    
    public function updated_status(Request $request){
        $user=User::find($request->user_id);
        $user->call_cender_status = $request->status;
        $user->calender =  $request->calendar;
        $user->extra_input = $request->extra_input;
        $user->save();
        return response()->json(['message' => 'Status Updated Successfully']);
    }
    public function send_data_not_answer(Request $request){
        $user=User::find($request->user_id);
        $user->call_cender_status = $request->status;
        $user->save();
        return response()->json(['message' => 'Status Updated Successfully']);
    }
    
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
                    $usersQuery->whereBetween("created_at", [
                        $now->startOfWeek()->format('Y-m-d'), //This will return date in format like this: 2022-01-10
                        $now->endOfWeek()->format('Y-m-d')
                    ]);
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
