<?php

namespace App\Console\Commands;

use App\Models\UserBalance;
use App\Models\UserBalanceHistory;
use App\User;
use Illuminate\Console\Command;

class SettleUserBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settle:balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Settle the difference between balances because of some bugs or unknown issues.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users =User::all();

        $bar = $this->output->createProgressBar(count($users));

        foreach($users as $user)
        {
            $balance = UserBalance::where('user_id', (int) $user->id)->firstOrFail();

            $cash = $balance->histories()->operationOf('add')->typeOf('cash')->sum('amount') -  $balance->histories()->operationOf('withdraw')->typeOf('cash')->sum('amount');
            $referralCash =  $balance->histories()->operationOf('add')->typeOf('referral')->sum('amount') -  $balance->histories()->operationOf('withdraw')->typeOf('referral')->sum('amount');

            $balance->cash = $cash;
            $balance->referral = $referralCash;

            $balance->save();

            $bar->advance();
        }

        $bar->finish();
        $this->info('');
        $this->info('Task completed');
    }
}
