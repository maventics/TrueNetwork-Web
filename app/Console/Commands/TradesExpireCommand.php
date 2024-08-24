<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationController;
use App\Models\Investment;
use App\Models\User;
use Illuminate\Console\Command;

class TradesExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trades-expire-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTrades = Investment::where('status',1)->expired()->get();
        $dry = new NotificationController();

        // $dry->sendNotificationToSingleUser('ea3z-Cx8TfusQ7qNHFTWm0:APA91bFacaikXaR8_LV3h4zxptXObCq7pNmNvgNq98isX5pW9kgtjboPh0jme4pOAeNXGEn8PCWt_U1aJrYkvhoXnXn1G_25D1bgyps2Sr9G1KWkPVuS-QGji6fumuA4MvtuLxm-3_9k', 'as been completed', 'Claim your profit in trades!', '/trades');
        foreach ($expiredTrades as $trade) {
            // Mark the trade as expired (update its status or perform other actions)
            //$trade->update(['status' => 0]);
            
                $trade->status = 0;
                $trade->save();
                $user = User::find($trade->user_id);
                if ($user->device_token) {
                    $dry->sendNotificationToSingleUser($user->device_token, 'Your trade has been completed', 'Claim your profit in trades!', '/trades');
                }
            
            // Perform any other necessary actions, such as notifying users, logging, etc.
        }

        $this->info('Expired trades processed successfully.');
    }
}
