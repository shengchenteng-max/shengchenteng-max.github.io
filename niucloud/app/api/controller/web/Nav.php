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

namespace app\api\controller\web;

use app\service\api\web\NavService;
use core\base\BaseApiController;
use think\Response;

class Nav extends BaseApiController
{
    /**
     * 导航列表
     * @return Response
     */
    public function lists()
    {
        return success(( new NavService() )->getList());
    }

}
