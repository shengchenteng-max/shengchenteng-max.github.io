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

use think\facade\Route;

use app\adminapi\middleware\AdminCheckRole;
use app\adminapi\middleware\AdminCheckToken;
use app\adminapi\middleware\AdminLog;

/**
 * 电脑端相关
 */
Route::group('web', function() {

    /***************************************************** 电脑端管理 ****************************************************/
    //链接列表
    Route::get('link', 'web.Config/getLink');

    //首页导航分页列表
    Route::get('nav', 'web.Nav/pages');

    //首页导航列表
    Route::get('nav/list', 'web.Nav/lists');

    //首页导航详情
    Route::get('nav/:id', 'web.Nav/info');

    //添加首页导航
    Route::post('nav', 'web.Nav/add');

    //添加首页导航
    Route::put('nav/:id', 'web.Nav/edit');

    //删除首页导航
    Route::delete('nav/:id', 'web.Nav/del');

    //修改首页导航排序号
    Route::put('nav/sort', 'web.Nav/editSort');

    //友情链接列表
    Route::get('friendly_link', 'web.FriendlyLink/lists');

    //友情链接详情
    Route::get('friendly_link/:id', 'web.FriendlyLink/info');

    //添加友情链接
    Route::post('friendly_link', 'web.FriendlyLink/add');

    //编辑友情链接
    Route::put('friendly_link/:id', 'web.FriendlyLink/edit');

    //删除友情链接
    Route::delete('friendly_link/:id', 'web.FriendlyLink/del');

    //修改友情链接排序号
    Route::put('friendly_link/sort', 'web.FriendlyLink/editSort');


    /***************************************************** 广告管理 *****************************************************/
    // 广告位管理
    Route::get('adv_position', 'web.Adv/advPosition');

    //广告管理
    Route::get('adv', 'web.Adv/pages');

    Route::get('adv/:id', 'web.Adv/info');

    Route::post('adv', 'web.Adv/add');

    Route::put('adv/:id', 'web.Adv/edit');

    Route::delete('adv/:id', 'web.Adv/del');

    //修改广告位排序号
    Route::put('adv/sort', 'web.Adv/editSort');

})->middleware([
    AdminCheckToken::class,
    AdminCheckRole::class,
    AdminLog::class
]);
