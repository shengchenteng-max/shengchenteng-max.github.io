<?php
// +----------------------------------------------------------------------
// | Niucloud-mall 企业快速开发的多应用管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

use app\api\middleware\ApiChannel;
use app\api\middleware\ApiCheckToken;
use app\api\middleware\ApiLog;
use think\facade\Route;


/**
 * 商城系统
 */
Route::group('web', function() {

    /***************************************************** 菜单信息相关接口 ****************************************************/

    // 导航列表
    Route::get('nav', 'web.Nav/lists');

    // 友情链接
    Route::get('friendly_link', 'web.FriendlyLink/lists');

    // 广告位
    Route::get('adv', 'web.Adv/getAdv');

})->middleware(ApiChannel::class)
    ->middleware(ApiCheckToken::class)//false表示不验证登录
    ->middleware(ApiLog::class);
