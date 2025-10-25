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
 * 退款成功事件
 */
class RefundSuccessListener
{
    public function handle(array $refund_info)
    {
        //添加账单记录
        (new CoreAccountService())->addRefundLog($refund_info['refund_no']);
    }
}
