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

namespace app\service\core\upload;

use app\dict\sys\StorageDict;
use app\service\core\sys\CoreConfigService;
use core\base\BaseCoreService;

/**
 * 上传服务层
 */
class CoreStorageService extends BaseCoreService
{

    /**
     * 获取当前启用的存储方式以及配置
     * @return void
     */
    public function getDefaultStorage()
    {
        $storage_list = $this->getStorageConfigList();
        foreach($storage_list as $k => $v){
            if($v['is_use'] == StorageDict::ON){
                $item_storage = $v['params'] ?? [];
                $item_storage['storage_type'] = $v['storage_type'];
                return $item_storage;
            }
        }
    }

    /**
     * 通过存储方式获取配置
     * @param string $type
     * @return array|mixed|void
     */
    public function getStorageByType(string $type){
        $storage_list = $this->getStorageConfigList();
        foreach($storage_list as $k => $v){
            if($v['storage_type'] == $type){
                $item_storage = $v['params'] ?? [];
                $item_storage['storage_type'] = $v['storage_type'];
                return $item_storage;
            }
        }

    }
    /**
     * 获取存储配置
     * @return void
     */
    public function getStorageConfig(){
        $info = (new CoreConfigService())->getConfig('STORAGE')['value'] ?? [];
        if(empty($info))
            $info = ['default' => StorageDict::LOCAL];

        return $info;


    }

    /**
     * 获取云存储列表
     * @return array
     */
    public function getStorageList()
    {
        $config_type = $this->getStorageConfig();
        $storage_type_list = StorageDict::getType();
        $list = [];
        foreach ($storage_type_list as $k => $v) {
            $data = [];
            $data['storage_type'] = $k;
            $data['is_use'] = $k == $config_type['default'] ? StorageDict::ON : StorageDict::OFF;
            $data['name'] = $v['name'];
            $data['component'] = $v['component'];
            foreach ($v['params'] as $k_param => $v_param) {
                $data['params'][$k_param] = [
                    'name' => $v_param,
                    'value' => $config_type[$k][$k_param] ?? ''
                ];
            }
            $list[] = $data;
        }
        return $list;
    }


    /**
     * 获取配置列表
     * @return array
     */
    public function getStorageConfigList()
    {
        $config_type = $this->getStorageConfig();
        $storage_type_list = StorageDict::getType();
        $list = [];
        foreach ($storage_type_list as $k => $v) {
            $data = [];
            $data['storage_type'] = $k;
            $data['is_use'] = $k == $config_type['default'] ? StorageDict::ON : StorageDict::OFF;
            $data['name'] = $v['name'];
            foreach ($v['params'] as $k_param => $v_param) {
                $data['params'][$k_param] = $config_type[$k][$k_param] ?? '';
            }
            $list[] = $data;
        }
        return $list;
    }
}
