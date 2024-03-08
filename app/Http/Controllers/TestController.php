<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Str;

class TestController extends Controller
{


    //create method
    public function create(Request $request)
    {
        $uid = Str::uuid();
        try{
            $data = new User();
            $data->uid = $uid;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = $request->password;
            $data->save();

            $result = $request->all();

            WebhookCall::create()
            ->url(env('WEBHOOK_CLIENT_URL').'/webhooks')
            ->payload([$result])
            ->useSecret('mainkey')
            ->dispatch();
        }
        catch(\Exception $e){
            Response($e->getMessage())->send();
        }
    }

    //update method
    public function update(Request $request, $id)
    {
        $uid = Str::uuid();
        // logger($id, $request->all());
        try{
            $data = User::find($id);
            // $data->uid = $uid;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = $request->password;
            $data->save();

            // $payload = [
            //     'uid' => $data->uid,
            //     'name' => $data->name,
            //     'email' => $data->email,
            //     'password' => $data->password, 
            // ];

            $result = $request->all();

            WebhookCall::create()
            ->url(env('WEBHOOK_CLIENT_URL').'/webhooks')
            ->payload([$result])
            ->useSecret('mainkey')
            ->dispatch();
        }
        catch(\Exception $e){
            Response($e->getMessage())->send();
        }
    }
}