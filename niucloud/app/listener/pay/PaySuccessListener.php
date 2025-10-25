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

namespace app\listener\pay;

use app\service\core\pay\CoreAccountService;

/**
 * 支付异步回调事件
 */
class PaySuccessListener
{
    public function handle(array $pay_info)
    {
        //账单记录添加
        (new CoreAccountService())->addPayLog($pay_info);

    }
}
