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

namespace app\service\api\pay;

use app\dict\common\ChannelDict;
use app\dict\pay\PayDict;
use app\dict\pay\PaySceneDict;
use app\model\member\Member;
use app\model\pay\Pay;
use app\model\sys\Poster;
use app\service\core\member\CoreMemberService;
use app\service\core\pay\CorePayService;
use core\base\BaseApiService;
use core\exception\ApiException;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 支付业务
 */
class PayService extends BaseApiService
{

    public $core_pay_service;
    public function __construct()
    {
        parent::__construct();
        $this->core_pay_service = new CorePayService();
    }

    /**
     * 去支付
     * @param string $type
     * @param string $trade_type
     * @param int $trade_id
     * @param string $return_url
     * @param string $quit_url
     * @param string $buyer_id
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function pay(string $type, string $trade_type, int $trade_id, string $return_url = '', string $quit_url = '', string $buyer_id = '', string $voucher = '', string $openid = ''){

        $member = (new CoreMemberService())->getInfoByMemberId($this->member_id);
        switch ($this->channel) {
            case ChannelDict::WECHAT://公众号
                $openid = $openid ? $openid : $member['wx_openid'] ?? '';
                break;
            case ChannelDict::WEAPP://微信小程序
                $openid = $openid ? $openid : $member['weapp_openid'] ?? '';
                break;
        }

        return $this->core_pay_service->pay($trade_type, $trade_id, $type, $this->channel, $openid, $return_url, $quit_url, $buyer_id, $voucher, $this->member_id);
    }

    /**
     * 关闭支付
     * @param string $type
     * @param string $out_trade_no
     * @return null
     */
    public function close(string $type, string $out_trade_no){
        return $this->core_pay_service->close($out_trade_no);
    }

    /**
     * 支付异步通知
     * @param string $channel
     * @param string $type
     * @param string $action
     * @return void|null
     */
    public function notify(string $channel, string $type, string $action){
        return $this->core_pay_service->notify($channel, $type, $action);
    }

    /**
     * 通过交易流水号查询支付信息以及支付方式
     * @param $out_trade_no
     * @return array
     */
    public function getInfoByOutTradeNo($out_trade_no){
        return $this->core_pay_service->getInfoByOutTradeNo($out_trade_no, $this->channel);
    }

    public function getInfoByTrade(string $trade_type, int $trade_id, array $data){
        return $this->core_pay_service->getInfoByTrade($trade_type, $trade_id, $this->channel, $data['scene']);
    }

    /**
     * 获取找朋友帮忙付支付信息
     * @param string $trade_type
     * @param int $trade_id
     * @return array
     */
    public function getFriendspayInfoByTrade($trade_type, $trade_id){
        $from_pay_info = ( new Pay() )->field('id')->where([ [ 'trade_type', '=', $trade_type ], [ 'trade_id', '=', $trade_id ] ])->findOrEmpty()->toArray();//查询发起交易所属的站点id
        if (empty($from_pay_info)) throw new ApiException('TRADE_NOT_EXIST');
        $pay_info = $this->core_pay_service->getInfoByTrade($trade_type, $trade_id, $this->channel, PaySceneDict::FRIENDSPAY);
        if (!empty($pay_info)) {
            //todo 查询订单交易信息，其它插件可实现该钩子
            $trade_info = array_values(array_filter(event('PayTradeInfo',[ 'trade_type' => $trade_type, 'trade_id' => $trade_id ])))[0] ?? [];
            $pay_info['trade_info'] = $trade_info;
            if ($pay_info['from_main_id'] != $this->member_id) {
                $pay_info['is_self'] = false;
            } else {
                $pay_info['is_self'] = true;
            }
            //海报
            $poster = ( new Poster() )->field('id')->where([
                [ 'type', '=', 'friendspay' ],
                [ 'status', '=', 1 ],
                [ 'is_default', '=', 1 ]
            ])->findOrEmpty()->toArray();
            if (!empty($poster)) {
                $pay_info['poster_id'] = $poster['id'];
            }
            //发起帮付会员信息
            $member = ( new Member() )->field('member_id,nickname,headimg')->where([
                [ 'member_id', '=', $pay_info['from_main_id'] ]
            ])->findOrEmpty()->toArray();
            $pay_info['member'] = $member;
        }
        return $pay_info;
    }

    /**
     * 获取支付方法
     * @param string $trade_type
     * @return array|array[]
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getPayTypeByTrade(string $trade_type){
        return $this->core_pay_service->getPayTypeByTrade($trade_type, $this->channel);
    }
}
