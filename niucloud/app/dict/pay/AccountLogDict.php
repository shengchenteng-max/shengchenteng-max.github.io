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

namespace app\dict\pay;

class AccountLogDict
{
    const PAY = 'pay';//支付
    const REFUND = 'refund'; //退款
    const TRANSFER = 'transfer'; //转账

    /**
     * 站点状态
     * @return array
     */
    public static function getType()
    {
        return [
            self::PAY => get_lang('dict_pay.pay'),//支付
            self::REFUND => get_lang('dict_pay.refund'),//退款
            self::TRANSFER => get_lang('dict_pay.transfer'),//转账
        ];
    }

}