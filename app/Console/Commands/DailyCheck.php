<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Console\Command;

class DailyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:check';

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
        $users = User::where('is_paid',1)->where('end_at',today()->format('Y-m-d'))->get();
        foreach($users as $user){
            $user->is_paid = 0;
            $user->is_finish= 1;
            $user->is_free = 0;
            $user->save();
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => '',
                'title' => 'تم انتهاء الاشتراك الخاص بك',
                'time' => $user->updated_at
            ];
        $user->notify(new GeneralNotification($date_send));
        }
        $this->info('Successfully sent daily check to everyone.');

    }
}
