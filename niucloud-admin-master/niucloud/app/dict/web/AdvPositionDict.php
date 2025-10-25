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

namespace app\dict\web;

use core\dict\DictLoader;

/**
 * 系统广告位
 * Class AdvPositionDict
 * @package app\dict\web
 */
class AdvPositionDict
{

    public static function getAdvPosition()
    {
        $system_adv_position = [
//            [
//                'keywords' => '', //关键字不能重复
//                'ap_name' => '', //广告位名称
//                'ap_desc' => '', //广告位简介
//                'default_content' => [], //默认数据
//                'ap_bg_color' => '', //背景色，默认白色
//            ]
        ];
        return ( new DictLoader("AdvPosition") )->load($system_adv_position);
    }

}
