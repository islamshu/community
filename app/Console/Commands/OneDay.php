<?php

namespace App\Console\Commands;

use App\Mail\AlertSubscribe;
use App\Mail\SubSubscribeNow;
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
    protected $signature = 'after1day:check';

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
        $threeDaysFromNow = $now->addDays(1);
        $users = User::where('is_paid',1)->where('end_at', $threeDaysFromNow)->get();
        
        foreach($users as $user){
            // $user->is_paid = 0;
            // $user->is_finish= 1;
            // $user->is_free = 0;
            // $user->save();
            $link = 'https://community.arabicreators.com/renew-packages';

            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' =>  $link,
                'title' => 'غدا سيتنهي اشتراكك انقر للتجديد',
                'time' => $user->updated_at
            ];
        $user->notify(new GeneralNotification($date_send));
        Mail::to($user->email)->send(new SubSubscribeNow($user->name,$user->email,$link));
        }
        $this->info('Successfully sent daily check to everyone.');

    }
}
