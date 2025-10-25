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

namespace app\service\core\pay;

use app\model\pay\AccountLog;
use app\model\pay\Pay;
use app\model\pay\Refund;
use app\model\pay\Transfer;
use core\base\BaseCoreService;

/**
 * 站点账单记录服务层
 * Class CoreAccountService
 * @package app\service\core\pay
 */
class CoreAccountService extends BaseCoreService
{

    /**
     * 添加支付账单
     * @param array $pay_info
     * @return mixed
     */
    public function addPayLog(array $pay_info)
    {
        $pay_info = (new Pay())->where([['out_trade_no', '=', $pay_info['out_trade_no']]])->findOrEmpty()->toArray();
        $data = [
            'type' => 'pay',
            'money' => $pay_info['money'],
            'trade_no' => $pay_info['out_trade_no'],
        ];
        $res = (new AccountLog())->create($data);
        return $res->id;
    }

    /**
     * 添加退款账单记录
     * @param string $refund_no
     * @return mixed
     */
    public function addRefundLog(string $refund_no)
    {
        $refund_info = (new Refund())->where([['refund_no', '=', $refund_no]])->findOrEmpty()->toArray();
        $data = [
            'type' => 'refund',
            'money' => $refund_info['money'] *(-1),
            'trade_no' => $refund_info['refund_no'],
        ];
        $res = (new AccountLog())->create($data);
        return $res->id;
    }

    /**
     * 添加转账账单记录
     * @param string $transfer_no
     * @return mixed
     */
    public function addTransferLog(string $transfer_no)
    {
        $transfer_info = (new Transfer())->where([['transfer_no', '=', $transfer_no]])->findOrEmpty()->toArray();
        $data = [
            'type' => 'transfer',
            'money' => $transfer_info['money'] *(-1),
            'trade_no' => $transfer_info['transfer_no'],
        ];
        $res = (new AccountLog())->create($data);
        return $res->id;
    }

}
