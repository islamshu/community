<?php
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\User;
use App\Mail\ReminderEmail;
use App\Models\Community;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Mail;

class SendReminder extends Command
{
    protected $signature = 'reminder:send';
    protected $description = 'Send reminder to all users before 3 hours from meeting date';

    public function handle()
    {
        $communities = Community::all();

        foreach ($communities as $community) {
            $meetingDate = Carbon::parse($community->meeting_date);
            $reminderDate = $meetingDate->subHours(3);

            // Fetch users associated with the community based on relevant criteria
            $users = ModelsUser::get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new ReminderEmail($reminderDate,$community->id));
            }
        }

        $this->info('Reminder emails sent successfully.');
    }
}
