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

namespace app\service\core\niucloud;

use app\dict\sys\ConfigKeyDict;
use app\service\core\sys\CoreConfigService;
use core\base\BaseCoreService;

/**
 * 官网授权管理服务层
 */
class CoreNiucloudConfigService extends BaseCoreService
{

    /**
     * 获取牛云配置
     * @return array|mixed|string[]
     */
    public function getNiucloudConfig(){
        $info = (new CoreConfigService())->getConfig(ConfigKeyDict::NIUCLOUD_CONFIG)['value'] ?? [];
        if(empty($info))
        {
            $info = [
                'auth_code' => '',
                'auth_secret' => ''
            ];
        }
        return $info;
    }


}
