<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

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

            $first = $data->uid;
            $second = $request->all();
            $result = array_merge(['client_uid' => $first], $second);

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
        try{
            $data = User::where('uid', $id)->first();
            // $data->uid = $uid;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = $request->password;
            $data->save();

            $first = $data->uid;
            $second = $data->client_uid;
            $third = $request->all();
            $result = array_merge(['uid' => $first], ['client_uid' => $second], $third);

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

    //delete method
    public function delete($id){
        $user=User::where('uid',$id);
        $result=$user->delete();
        if($result){
            WebhookCall::create()
            ->url(env('WEBHOOK_CLIENT_URL').'/webhooks')
            ->payload([["code"=>1,"client_uid"=>$id]])
            ->useSecret('mainkey')
            ->dispatch();

            logger(json_encode("Delete Successfully"));
        }else{
            logger("error to delete the data");
        }
    }
}