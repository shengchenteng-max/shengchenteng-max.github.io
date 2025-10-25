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

namespace app\adminapi\controller\web;

use app\service\admin\web\WebService;
use core\base\BaseAdminController;


/**
 * PC控制器
 * Class Web
 * @package app\adminapi\controller\web
 */
class Config extends BaseAdminController
{

    /**
     * 获取自定义链接列表
     */
    public function getLink()
    {
        $web_service = new WebService();
        return success($web_service->getLink());
    }
}
