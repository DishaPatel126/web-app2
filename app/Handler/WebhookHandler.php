<?php

namespace App\Handler;

use App\Models\User;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Exception;


class WebhookHandler extends ProcessWebhookJob
{
    public function handle()
    {
        $uid = Str::uuid();
        try {
            logger('Webhook call started.');

            $data = json_decode($this->webhookCall, true)['payload'];
            logger($data);
            foreach ($data as $count) {
                if (isset($count['name'])) {
                    $data = new User;
                    $data->uid = $uid;
                    $data->client_uid = $count['client_uid'];
                    $data->name = $count['name'];
                    $data->email = $count['email'];
                    $data->password = $count['password'];
                    $data->save();

                    $p_client_uid = ['client_uid' => $uid];
                    $p_uid = ['uid' => $data->client_uid];
                    $payload = array_merge($p_uid, $p_client_uid);
                    // logger($payload);

                    WebhookCall::create()
                        ->url(env('WEBHOOK_CLIENT_URL') . '/webhooks')
                        ->payload($payload)
                        ->useSecret('mainkey')
                        ->dispatch();

                } else {
                    $uid1 = $data['uid'];
                    $data1 = User::where('uid', $uid1)->first();
                    $data1->client_uid = $data['client_uid'];
                    $data1->save();
                }
            }
            logger('Webhook data processed successfully.');

        } catch (Exception $e) {
            logger('Webhook call failed.');
            logger($e->getMessage());
        }
    }
}

        // try {
        //     logger('Webhook call started.');
        //     $data = json_decode($this->webhookCall, true)['payload'];

        //     foreach ($data as $userData) {
        //         $uid = $userData['uid'];

        //         $existingUser = User::where('uid', $uid)->first();

        //         if ($existingUser) {
        //             logger("Updating user with UID: $uid");
        //             $existingUser->update($userData);
        //         } else {
        //             logger("Creating user with UID: $uid");
        //             User::create($userData);
        //         }
        //     }
        //     logger('Webhook data processed successfully.');
        // } 