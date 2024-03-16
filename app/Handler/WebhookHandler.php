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
            // $existingUser = User::where('uid', $count['client_uid'])->first() ;

            // logger($data);
            foreach ($data as $count) {
                logger("count");
                logger($count);
                $existingUser = User::where('uid', $count['client_uid'])->first();
                $existingUser1 = User::where('client_uid', $count['client_uid'])->first();
                logger($existingUser);
                if ($existingUser || $existingUser1) {
                    // logger("code ");
                    // logger($count);
                    if (isset($count['code'])) {
                        $user = User::where('client_uid', $count['client_uid'])->first();
                        $result = $user->delete();
                        if ($result) {
                            logger("data deleted successfully");
                        } else {
                            logger("Error to deleted the data");
                        }
                    } else {


                        try {
                            $existingUser->name = $count['name'];
                            $existingUser->email = $count['email'];
                            $existingUser->password = $count['password'];
                            $existingUser->save();
                        } catch (Exception $e) {
                            logger("webhook fail for update user");
                            logger($e->getMessage());
                        }
                    }
                } else {
                    try {
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
                                ->payload([$payload])
                                ->useSecret('mainkey')
                                ->dispatch();
                        } else {
                            logger('This is else part');
                            // logger("count");
                            // logger($count);
                            $uid1 = $count['uid'];
                            $data1 = User::where('uid', $uid1)->first();
                            $data1->client_uid = $count['client_uid'];
                            $data1->save();
                        }
                    } catch (Exception $e) {
                        logger("for create");
                        logger($e->getMessage());
                    }
                }
            }
            logger('Webhook data processed successfully.');
        } catch (Exception $e) {
            logger('Webhook call failed.');
            logger($e->getMessage());
        }
    }
}
   /* public function handle()
    {
        $uid = Str::uuid();

        try {
            logger('Webhook call started.');

            $data = json_decode($this->webhookCall, true)['payload'];
            // logger($data);
            foreach ($data as $count) {
                logger("count");
                logger($count);
                $existingUser = User::where('uid', $count['client_uid'])->first();
                logger($existingUser);
                if ($existingUser) {
                    try {
                        $existingUser->name = $count['name'];
                        $existingUser->email = $count['email'];
                        $existingUser->password = $count['password'];
                        $existingUser->save();
                    } catch (Exception $e) {
                        logger("webhook fail for update user");
                        logger($e->getMessage());
                    }
                } else {
                    try {
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
                                ->payload([$payload])
                                ->useSecret('secretkey')
                                ->dispatch();
                        } else {
                            logger('This is else part');
                            logger("count");
                            logger($count);
                            $uid1 = $count['uid'];
                            $data1 = User::where('uid', $uid1)->first();
                            $data1->client_uid = $count['client_uid'];
                            $data1->save();
                        }
                    } catch (Exception $e) {
                        logger("for create");
                        logger($e->getMessage());
                    }
                }
            }
            logger('Webhook data processed successfully.');
        } catch (Exception $e) {
            logger('Webhook call failed.');
            logger($e->getMessage());
        }
    }
   
 */
