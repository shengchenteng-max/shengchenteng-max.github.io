<?php
// +----------------------------------------------------------------------
// | Niucloud-admin 企业快速开发的多应用管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

namespace app\adminapi\middleware;

use app\Request;
use app\service\admin\auth\LoginService;
use Closure;

/**
 * admin用户登录token验证
 * Class AdminCheckToken
 * @package app\adminapi\middleware
 */
class AdminCheckToken
{
    public function handle(Request $request, Closure $next)
    {
        //通过配置来设置系统header参数
        $token = $request->adminToken();
        $token_info = (new LoginService())->parseToken($token);
        $request->uid($token_info['uid']);
        $request->username($token_info['username']);
        return $next($request);
    }
}
