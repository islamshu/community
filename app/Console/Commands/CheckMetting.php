<?php

namespace App\Console\Commands;

use App\GoogleMeetService;
use App\Mail\ReminderEmail;
use App\Models\Community;
use App\Models\CommunityUser;
use App\Models\GeneralInfo;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckMetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'meeting description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDateTime = Carbon::now();
        $reminderDateTime = $currentDateTime->addHours(3);
        $reminderDateTimeFormatted = $reminderDateTime->format('Y-m-d\TH:i');

        $communities = Community::where('meeting_date',  $reminderDateTimeFormatted)->get();
        foreach ($communities as $community) {
            $meetingDate = Carbon::parse($community->meeting_date);
            $reminderDate = $meetingDate->subHours(3);

            // Fetch users associated with the community based on relevant criteria
            $users = User::where('is_paid',1)->get();

            

            foreach ($users as $user) {
                Mail::to($user->email)->send(new ReminderEmail($reminderDateTime,$community->id,$user->name));
            }
            $usersComm = CommunityUser::where('communitiye_id',$community->id)->get();
            foreach($usersComm as $us){
                $userCom = User::find($us->user_id);
                $date_send = [
                    'id' => $userCom->id,
                    'name' => $userCom->name,
                    'url' => $community->meeting_url,
                    'title' => 'سيبدأ الاجتماع الخاص ب '. $community->title .' بعد ',
                    'time' => $user->updated_at
                ];
                $userCom->notify(new GeneralNotification($date_send));
            }
        }
        $expire = get_general_value('meeting_end');
        $communitiess = Community::where('meeting_end','<=',now())->get();
        foreach($communitiess as $com){
            if ($com->peroid_type == 'day') {
                $startTime =  Carbon::parse($com->meeting_date)->addDays($com->peroid_number);
            } elseif ($com->peroid_type == 'week') {
                $startTime =  Carbon::parse($com->meeting_date)->addWeeks($com->peroid_number);
            }elseif($com->peroid_type == 'month'){
                $startTime =  Carbon::parse($com->meeting_date)->addMonths($com->peroid_number);
            }
            $endTime = Carbon::parse($startTime)->addMinute($com->meeting_time);
            $emails = ['islamshu12@gmail.com'];

            $googleAPI = new GoogleMeetService();
            $event = $googleAPI->createMeet($com->title, $com->title, $startTime, $endTime, $emails);
            $com->meeting_end = $endTime;
            $com->meeting_date = $startTime;
            $com->meeting_url = $event->hangoutLink;
            $com->meeting_id = $event->getId();
            $com->save();

        } 

    }
}
