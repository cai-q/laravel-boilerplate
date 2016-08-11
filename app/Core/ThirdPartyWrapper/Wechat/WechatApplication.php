<?php


namespace App\Core\ThirdPartyWrapper\Wechat;


use EasyWeChat\Foundation\Application;

/**
 * Class WechatApplication
 * @package App\Core\ThirdPartyWrapper\Wechat
 */
class WechatApplication
{
    /**
     * @var mixed
     */
    public $config;
    /**
     * @var \EasyWeChat\Foundation\Application
     */
    public $application;
    /**
     * @var \EasyWeChat\Server\Guard
     */
    public $server;

    /**
     * @var \Overtrue\Socialite\SocialiteManager
     */
    public $oauth;

    /**
     * WechatApplication constructor.
     */
    public function __construct()
    {
        $this->config = config('wechat');
        $this->application = new Application($this->config);
        $this->server = $this->application->server;
        $this->oauth = $this->application->oauth;
    }

    /**
     * 微信服务器验证的回调函数
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function serve()
    {
        return $this->server->serve();
    }

    /**
     * @return mixed
     */
    public function oAuthRedirect()
    {
        return $this->oauth->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticateRequest()
    {
        $user = $this->oauth->user();

        session(config('wechat.session_user_key'), $user->toArray());
        $target_url = session(config('wechat.target_url_before_redirect_key'), '/');

        return redirect($target_url);
    }
}