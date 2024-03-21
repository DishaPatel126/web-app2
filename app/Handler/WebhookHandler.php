<?php

namespace App\Handler;

use App\Models\User;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Str;
use Exception;

class WebhookHandler extends ProcessWebhookJob
{
    public function handle()
    {
        $payload = $this->webhookCall->payload;
        logger($payload);
    }
}
//         $uid = Str::uuid();
//         try {
//             logger('Webhook call started.');
//             $data = json_decode($this->webhookCall, true)['payload'];

//             foreach ($data as $count) {
//                 logger("count");
//                 logger($count);
//                 $existingUser = User::where('uid', $count['client_uid'])->first(); //for update
//                 $existingUser1 = User::where('client_uid', $count['client_uid'])->first(); //for delete
//                 logger($existingUser);
//                 if ($existingUser || $existingUser1) {
//                     // checks if "code" is set or not, if yes then deleteUser is executed, else updateUser
//                     if (isset($count['code'])) {
//                         $this->deleteUser($existingUser1, $count);
//                     } else {
//                         $this->updateUser($existingUser, $count);
//                     }
//                 }
//                 // if user not found then create new user 
//                 else {
//                     $this->createUser($uid, $count);
//                 }
//             }
//             logger('Webhook data processed successfully.');
//         } catch (Exception $e) {
//             logger('Webhook call failed.');
//             logger($e->getMessage());
//         }
//     }

//     // method for creating new user
//     protected function createUser($uid, $count)
//     {
//         try {
//             if (isset($count['name'])) {
//                 $data = new User;
//                 $data->uid = $uid;
//                 $data->client_uid = $count['client_uid'];
//                 $data->name = $count['name'];
//                 $data->email = $count['email'];
//                 $data->password = $count['password'];
//                 $data->save();

//                 $p_client_uid = ['client_uid' => $uid];
//                 $p_uid = ['uid' => $data->client_uid];
//                 $payload = array_merge($p_uid, $p_client_uid);

//                 WebhookCall::create()
//                     ->url(env('WEBHOOK_CLIENT_URL') . '/webhooks')
//                     ->payload([$payload])
//                     ->useSecret('mainkey')
//                     ->dispatch();
//             } 
//             // if user is created from opposite end then client_uid is updated at opposite end
//             else {
//                 $uid1 = $count['uid'];
//                 $data1 = User::where('uid', $uid1)->first();
//                 $data1->client_uid = $count['client_uid'];
//                 $data1->save();
//             }
//         } catch (Exception $e) {
//             logger("for create");
//             logger($e->getMessage());
//         }
//     }

//     // method for updating existing user
//     protected function updateUser($existingUser, $count)
//     {
//         try {
//             $existingUser->name = $count['name'];
//             $existingUser->email = $count['email'];
//             $existingUser->password = $count['password'];
//             $existingUser->save();
//         } catch (Exception $e) {
//             logger("webhook fail for update user");
//             logger($e->getMessage());
//         }
//     }

//     // method for deleting existing user
//     protected function deleteUser($existingUser1, $count)
//     {
//         $result = $existingUser1->delete();
//         if ($result) {
//             logger("data deleted successfully");
//         } else {
//             logger("Error to deleted the data");
//         }
//     }
// }
