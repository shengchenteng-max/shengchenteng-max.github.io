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

namespace app\service\core\aliapp;

use app\dict\sys\ConfigKeyDict;
use app\model\sys\SysConfig;
use app\service\core\sys\CoreConfigService;
use core\base\BaseCoreService;
use think\Model;

/**
 * 支付宝小程序配置
 * Class CoreAliappConfigService
 * @package app\service\core\Aliapp
 */
class  CoreAliappConfigService extends BaseCoreService
{
    /**
     * 获取支付宝小程序设置
     * @return array
     */
    public function getAliappConfig(){
        $info = (new CoreConfigService())->getConfig(ConfigKeyDict::ALIAPP)['value'] ?? [];
        return [
            'name' => $info['name'] ?? '',
            'app_id' => $info['app_id'] ?? '',
            'private_key'            => $info['private_key'] ?? '',
            'aes_key'        => $info['aes_key'] ?? '',
            'public_key_crt' =>  $info['public_key_crt'] ?? '',
            'alipay_public_key_crt' =>  $info['alipay_public_key_crt'] ?? '',
            'alipay_with_crt' =>  $info['alipay_with_crt'] ?? '',
            'qrcode' => $info['qrcode'] ?? ''
        ];
    }

    /**
     * 支付宝小程序配置
     * @param array $data
     * @return SysConfig|bool|Model
     */
    public function setAliappConfig(array $data){
        $config = [
            'name' => $data['name'] ?? '',
            'app_id' => $data['app_id'] ?? '',
            'private_key'            => $data['private_key'] ?? '',
            'aes_key'        => $data['aes_key'] ?? '',
            'public_key_crt' =>  $data['public_key_crt'] ?? '',
            'alipay_public_key_crt' =>  $data['alipay_public_key_crt'] ?? '',
            'alipay_with_crt' =>  $data['alipay_with_crt'] ?? '',
            'qrcode' => $data['qrcode'] ?? ''
        ];
        return (new CoreConfigService())->setConfig(ConfigKeyDict::ALIAPP, $config);
    }


}
