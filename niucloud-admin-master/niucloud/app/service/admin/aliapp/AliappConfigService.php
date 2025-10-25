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

namespace app\service\admin\aliapp;

use app\model\sys\SysConfig;
use app\service\core\aliapp\CoreAliappConfigService;
use core\base\BaseAdminService;
use think\Model;

/**
 * 支付宝小程序设置
 * Class AliappConfigService
 * @package app\service\admin\Aliapp
 */
class AliappConfigService extends BaseAdminService
{
    /**
     * 获取配置信息
     * @return array|null
     */
    public function getAliappConfig()
    {
        return (new CoreAliappConfigService())->getAliappConfig();
    }

    /**
     * 设置配置
     * @param array $data
     * @return SysConfig|bool|Model
     */
    public function setAliappConfig(array $data){
        return (new CoreAliappConfigService())->setAliappConfig($data);
    }

    /**
     * 服务器域名
     * @return array
     */
    public function static(){
        $domain = request()->domain();
        return [
            'domain' => $domain,
        ];

    }

}
