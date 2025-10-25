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

namespace app\service\core\wechat;

use core\base\BaseCoreService;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * 微信服务api提供
 * Class CoreWechatApiService
 * @package app\service\core\wechat
 */
class CoreWechatApiService extends BaseCoreService
{
    /**
     * 获取用户信息
     */
    public function userInfo(string $openid)
    {
        $api = CoreWechatService::appApiClient();
        return $api->get('/cgi-bin/user/info', [
            'openid' => $openid,
        ]);
    }

    /**
     * 批量获取用户基本信息
     * @param array $openids
     * @param string $lang
     * @return mixed
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function userInfoBatchget(array $openids, string $lang = 'zh_CN')
    {
        return CoreWechatService::appApiClient()->postJson('/cgi-bin/user/info/batchget', [
                'user_list' => array_map(function($openid) use ($lang) {
                    return [
                        'openid' => $openid,
                        'lang' => $lang,
                    ];
                }, $openids)
            ]
        );
    }

    /**
     * 用户列表(可以再外部设计一个递归查询全部的函数)  返回的是 openid
     */
    public function userGet(?string $next_openid = '')
    {
        $api = CoreWechatService::appApiClient();
        return $api->get('/cgi-bin/user/get', [ 'next_openid' => $next_openid ]);
    }

    /**
     * 创建菜单按钮接口
     * @param array $buttons
     * @param array $match_rule
     * @return mixed
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function menuCreate(array $buttons, array $match_rule = [])
    {
        $api = CoreWechatService::appApiClient();
        if (!empty($match_rule)) {
            return $api->postJson('cgi-bin/menu/addconditional', [
                'button' => $buttons,
                'matchrule' => $match_rule,
            ]);
        }

        return $api->postJson('cgi-bin/menu/create', [ 'button' => $buttons ]);
    }

}