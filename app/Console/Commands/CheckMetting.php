<?php

namespace App\Console\Commands;

use App\GoogleMeetService;
use App\Models\Community;
use App\Models\GeneralInfo;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        $expire = get_general_value('meeting_end');
        $communities = Community::where('meeting_end','<=',now())->get();
        foreach($communities as $com){
            if ($com->peroid_type == 'day') {
                $startTime =  Carbon::parse($com->meeting_date)->addDays($com->peroid_number);
            } elseif ($com->peroid_type == 'week') {
                $startTime =  Carbon::parse($com->meeting_date)->addWeeks($com->peroid_number);
            }elseif($com->peroid_type == 'month'){
                $startTime =  Carbon::parse($com->meeting_date)->addMonths($com->peroid_number);
            }
            $endTime = Carbon::parse($$com->peroid_type)->addMinute($com->meeting_time);
            $emails = ['islamshu12@gmail.com'];

            $googleAPI = new GoogleMeetService();
            $event = $googleAPI->createMeet($com->title, $com->title, $startTime, $endTime, $emails);
            $com->meeting_end = $endTime;
            $com->meeting_date = $startTime;
            $com->meeting_url = $event->hangoutLink();
            $com->meeting_id = $event->getId();
            $com->save();

        } 

    }
}
