<?php

namespace App\Console\Commands;

use App\Models\User;
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
            $user->save();
        }
        $this->info('Successfully sent daily check to everyone.');

    }
}
