<?php


namespace App\Core\Authentication\Wechat;


use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class IsWechatUser
 * @package App\Core\Authentication\Wechat
 * @mixin User
 */
trait IsWechatUser
{
    /**
     * @return array|null
     */
    public static function getWechatUserInstanceInSession()
    {
        return session(config('wechat.session_user_key'));
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $openID
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeOpenID(Builder $query, string $openID)
    {
        return $query->where('openid', $openID);
    }

    /**
     * @param array $wechatUser
     * @return static
     */
    public static function createInstanceByWechatUserInSession($wechatUser)
    {
        return User::create($wechatUser);
    }
}