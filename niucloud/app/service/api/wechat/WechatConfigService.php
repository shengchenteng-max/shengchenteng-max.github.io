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

namespace app\service\api\wechat;

use app\service\core\wechat\CoreWechatConfigService;
use core\base\BaseApiService;

/**
 * 微信配置模型
 * Class WechatConfigService
 * @package app\service\core\wechat
 */
class WechatConfigService extends BaseApiService
{
    /**
     * 检查微信公众号是否配置
     * @return bool
     */
    public function checkWechatConfig()
    {
        $config = (new CoreWechatConfigService())->getWechatConfig();
        if ( empty($config['app_id']) ) {
            return false;
        } else {
            return true;
        }
    }
}
