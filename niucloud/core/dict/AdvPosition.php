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
namespace core\dict;


class AdvPosition extends BaseDict
{
    /**
     * 广告位加载
     * @param array $data
     * @return array|mixed
     */
    public function load(array $data)
    {
        $addons = $this->getLocalAddons();
        $adv_position_files = [];
        foreach ($addons as $v) {
            $adv_position_path = $this->getAddonDictPath($v) . "web" . DIRECTORY_SEPARATOR . "adv_position.php";
            if (is_file($adv_position_path)) {
                $adv_position_files[] = $adv_position_path;
            }
        }
        $adv_position_file_data = $this->loadFiles($adv_position_files);
        $adv_position = $data;
        foreach ($adv_position_file_data as $file_data) {
            $adv_position = empty($adv_position) ? $file_data : array_merge($adv_position, $file_data);
        }
        return $adv_position;
    }
}
