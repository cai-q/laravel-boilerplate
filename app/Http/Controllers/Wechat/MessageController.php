<?php

namespace App\Http\Controllers\Wechat;

use App\Core\ThirdPartyWrapper\Wechat\WechatApplication;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function serve(WechatApplication $wechatApplication)
    {
        $wechatApplication->server->setMessageHandler(function () {
            return '消息测试成功！';
        });

        return $wechatApplication->serve();
    }
}
