<?php

namespace App\Handler;

use App\Models\User;
use App\Models\Product;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Str;
use Exception;

class WebhookHandler extends ProcessWebhookJob
{
    public function handle()
    {
        try {
            logger('Webhook call started.');
            $payload = json_decode($this->webhookCall, true)['payload'];
            foreach ($payload as $count) {
                logger($count);

                $existingProduct = Product::where('code', $count['code'])->first();
                // logger($existingProduct);
                if ($existingProduct) {
                    // checks if "code" is set or not, if yes then deleteUser is executed, else updateUser
                    if (isset($count['key'])) {
                        $this->deleteProduct($existingProduct);
                    } else {
                        $this->updateProduct($existingProduct, $count);
                    }
                }
                // if user not found then create new user 
                else {
                    $this->createProduct($count);
                }
            }
            logger('Webhook data processed successfully.');
        } catch (Exception $e) {
            logger('Webhook call failed.');
            logger($e->getMessage());
        }
    }

    // method for creating new product
    protected function createProduct($count)
    {
        logger("create product");
        try {
            if (isset($count['code'])) {
                $data = new Product;
                $data->id = $count['id'];
                $data->code = $count['code'];
                $data->name = $count['name'];
                $data->quantity = $count['quantity'];
                $data->price = $count['price'];
                $data->description = $count['description'];
                $data->save();
            } else {
                logger("else part");
            }
        } catch (Exception $e) {
            logger("Webhook failed for create product");
            logger($e->getMessage());
        }
    }

    // method for updating existing user
    protected function updateProduct($data, $count)
    {
        logger("update product");
        logger($count);
        try {
            $data->id = $count['id'];
            $data->code = $count['code'];
            $data->name = $count['name'];
            $data->quantity = $count['quantity'];
            $data->price = $count['price'];
            $data->description = $count['description'];
            $data->save();
        } catch (Exception $e) {
            logger("webhook fail for update product");
            logger($e->getMessage());
        }
    }

    // method for deleting existing user
    protected function deleteProduct($data)
    {
        logger("delete product");
        $result = $data->delete();
        if ($result) {
            logger("data deleted successfully");
        } else {
            logger("Error to deleted the data");
        }
    }
}

    //         foreach ($data as $count) {
    //             logger("count");
    //             logger($count);
    //             $existingProduct = User::where('id', $count['id'])->first(); //for update
    //             $existingProduct1 = User::where('code', $count['code'])->first(); //for delete
    //             logger($existingProduct);
    //             if ($existingProduct || $existingProduct1) {
    //                 // checks if "code" is set or not, if yes then deleteUser is executed, else updateUser
    //                 if (isset($count['code'])) {
    //                     $this->deleteUser($existingUser1, $count);
    //                 } else {
    //                     $this->updateUser($existingUser, $count);
    //                 }
    //             }
    //             // if user not found then create new user 
    //             else {
    //                 $this->createUser($uid, $count);
    //             }
    //         }
    //         logger('Webhook data processed successfully.');
    //     } catch (Exception $e) {
    //         logger('Webhook call failed.');
    //         logger($e->getMessage());
    //     }
    // }

    // method for creating new user
    

    // method for updating existing user
    // protected function updateUser($existingUser, $count)
    // {
    //     try {
    //         $existingUser->name = $count['name'];
    //         $existingUser->email = $count['email'];
    //         $existingUser->password = $count['password'];
    //         $existingUser->save();
    //     } catch (Exception $e) {
    //         logger("webhook fail for update user");
    //         logger($e->getMessage());
    //     }
    // }

    // // method for deleting existing user
    // protected function deleteUser($existingUser1, $count)
    // {
    //     $result = $existingUser1->delete();
    //     if ($result) {
    //         logger("data deleted successfully");
    //     } else {
    //         logger("Error to deleted the data");
    //     }
    // }
