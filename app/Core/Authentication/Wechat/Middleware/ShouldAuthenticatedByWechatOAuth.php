<?php


namespace App\Core\Authentication\Wechat\Middleware;


use App\Core\ThirdPartyWrapper\Wechat\WechatApplication;
use Closure;
use Illuminate\Http\Request;
use Session;

/**
 * Class ShouldAuthenticatedByWechat
 * @package App\Core\Authentication\Wechat\Middleware
 */
class ShouldAuthenticatedByWechatOAuth
{
    /**
     * @var \App\Core\ThirdPartyWrapper\Wechat\WechatApplication
     */
    public $wechatApplication;

    /**
     * ShouldAuthenticatedByWechat constructor.
     */
    public function __construct()
    {
        $this->wechatApplication = app()->make(WechatApplication::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->hasAuthenticatedWechatUser()) {
            return $this->redirectToWechatOAuthPage($request);
        }

        return $next($request);
    }

    /**
     * @return bool
     */
    protected function hasAuthenticatedWechatUser()
    {
        return Session::has(config('wechat.session_user_key'));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    private function redirectToWechatOAuthPage(Request $request)
    {
        session(config('wechat.target_url_before_redirect_key'), $request->fullUrl());

        return $this->wechatApplication->oAuthRedirect();
    }
}