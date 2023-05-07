<?php

namespace App\Console\Commands;

use App\GoogleMeetService;
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
        if (now() >= $expire) {
            $summary = 'المجتمع العربي ';
            $description =  'المجتمع العربي ';
            if (get_general_value('peroid_type') == 'day') {
                $startTime =  Carbon::parse(get_general_value('meeting_date'))->addDays(get_general_value('peroid_number'));
            } elseif (get_general_value('peroid_type') == 'week') {
                $startTime =  Carbon::parse(get_general_value('meeting_date'))->addWeeks(get_general_value('peroid_number'));
            }
        } elseif (get_general_value('peroid_type') == 'month') {
            $startTime =  Carbon::parse(get_general_value('meeting_date'))->addMonths(get_general_value('peroid_number'));
        }
        GeneralInfo::setValue('meeting_date', $startTime);

        $endTime = Carbon::parse(get_general_value('meeting_date'))->addMinute(get_general_value('meeting_time'));
        GeneralInfo::setValue('meeting_end', $endTime);

        $emails = ['islamshu12@gmail.com'];


        $googleAPI = new GoogleMeetService();
        $event = $googleAPI->createMeet($summary, $description, $startTime, $endTime, $emails);
        GeneralInfo::setValue('meeting_url', $event->hangoutLink);
        GeneralInfo::setValue('finish_time', $event->end->dateTime);
        $this->info('Successfully sent daily check to everyone.');
    }
}
