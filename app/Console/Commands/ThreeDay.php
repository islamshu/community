<?php

namespace App\Console\Commands;

use App\Mail\AlertSubscribe;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ThreeDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'after3day:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = today();
        $threeDaysFromNow = $now->addDays(3);
        $users = User::where('is_paid',1)->where('end_at', $threeDaysFromNow)->get();
        foreach($users as $user){
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => '',
                'title' => 'سينتهي الاشتراك بعد ثلاث ايام !',
                'time' => $user->updated_at
            ];
            $user->notify(new GeneralNotification($date_send));
            Mail::to($user->email)->send(new AlertSubscribe($user->name,$user->email, $threeDaysFromNow));
        }
        $this->info('Successfully sent daily check to everyone.');

    }
}
