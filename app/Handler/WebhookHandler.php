<?php

namespace App\Handler;

use App\Models\User;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Exception;


class WebhookHandler extends ProcessWebhookJob
{
    public function handle()
    {
        try {
            logger('Webhook call started.');
            $data = json_decode($this->webhookCall, true)['payload'];

            foreach ($data as $userData) {
                $uid = $userData['uid'];

                $existingUser = User::where('uid', $uid)->first();

                if ($existingUser) {
                    logger("Updating user with UID: $uid");
                    $existingUser->update($userData);
                } else {
                    logger("Creating user with UID: $uid");
                    User::create($userData);
                }
            }

            logger('Webhook data processed successfully.');
        } catch (Exception $e) {
            logger('Webhook call failed. ');
            logger($e->getMessage());
        }
    }
}
