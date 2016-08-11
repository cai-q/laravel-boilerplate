<?php

namespace App\Http\Controllers\Wechat;

use App\Core\ThirdPartyWrapper\Wechat\WechatApplication;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OAuthController extends Controller
{

    public function callback(WechatApplication $wechatApplication, User $user)
    {
        return $wechatApplication->authenticateRequest();
    }
}
