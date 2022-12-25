<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class NotificationController extends Controller
{
  
    public function index()
    {
        $title = "Ecommerce | Full Store Website";
        $this->html('chat', ['title' => $title], true);
    }
    
    public function saveToken(Request $request)
    {
       $token_pass = $request->token;
       if(isLoggedIn()){
            $token = $this->post('user-registration', ['data' => ['type' => 'register-device', 'user_id' => session()->get('user') ['user_id'], 'token' => $token_pass]]); 
       }else{
            $token = $this->post('store-fcm-id', ['data' => ['fcm_id' => $token_pass]]);  
       }
       
        return response()->json($token);
    }

}