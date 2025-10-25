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

use app\dict\cash_out\CashOutTypeDict;
use app\service\core\member\CoreMemberCashOutService;
use app\service\core\pay\CoreAccountService;

/**
 * 转账事件
 */
class TransferSuccessListener
{
    public function handle(array $info)
    {
        //添加账单记录
        (new CoreAccountService())->addTransferLog($info['transfer_no']);
        //会员零钱提现
        if ($info['trade_type'] == CashOutTypeDict::MEMBER_CASH_OUT) {
            return (new CoreMemberCashOutService())->transferFinish($info['transfer_no']);
        }
    }
}
