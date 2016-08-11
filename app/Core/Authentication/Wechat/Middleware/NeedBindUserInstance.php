<?php


namespace App\Core\Authentication\Wechat\Middleware;


use App\Core\Authentication\Wechat\Exceptions\WechatUserNotInSessionException;
use App\Http\Requests\Request;
use App\User;
use Closure;

class NeedBindUserInstance
{
    public function handle(Request $request, Closure $next)
    {
        $session_user = User::getWechatUserInstanceInSession();

        if (is_null($session_user)) {
            throw new WechatUserNotInSessionException();
        }

        if (! $user = User::openID($session_user['id'])->first()) {
            $user = User::createInstanceByWechatUserInSession($session_user);
        }

        $this->bindUserInstance($user);

        return $next($request);
    }

    /**
     * @param $user
     */
    protected function bindUserInstance($user)
    {
        app()->singleton(User::class, function () use ($user) {
            return $user;
        });
    }
}