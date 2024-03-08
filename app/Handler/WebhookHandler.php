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
            $data = (array) json_decode($this->webhookCall, true)['payload'];
            logger($data);

            $array = [];
            foreach ($data as $count) {
                foreach ($count as $key => $value) {
                    logger($key . ' : ' . $value); 
                }
                $array[] = $count; 
            }
            $result = User::create($count);
                    if ($result) {
                        logger('User created successfully.');
                    } else {
                        logger('User creation failed.');
                    }
        } catch (Exception $e) {
            logger('Webhook call failed. ');
            logger($e->getMessage());
        }
    }
}
