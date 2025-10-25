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

use app\service\api\web\AdvService;
use core\base\BaseApiController;

class Adv extends BaseApiController
{

    public function getAdv()
    {
        $data = $this->request->params([
            [ 'adv_key', '' ]
        ]);
        return success(( new AdvService() )->getInfo($data[ 'adv_key' ]));
    }

}
