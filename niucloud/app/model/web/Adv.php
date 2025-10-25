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

namespace app\model\web;


use app\dict\web\AdvPositionDict;
use core\base\BaseModel;

/**
 * 广告管理
 * Class Adv
 * @package app\model\web
 */
class Adv extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'adv_id';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'web_adv';

    // 设置json类型字段
    protected $json = [ 'adv_url' ];
    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

    /**
     * 搜索器:广告位key
     * @param $value
     * @param $data
     */
    public function searchAdvKeyAttr($query, $value, $data)
    {
        if ($value) {
            $query->where("adv_key", "=", $value);
        }
    }

    /**
     * 获取广告位名称
     * @param $value
     * @param $data
     * @return mixed|string
     */
    public function getApNameAttr($value, $data)
    {
        if (empty($data[ 'adv_key' ]))
            return '';
        $adv_position = AdvPositionDict::getAdvPosition();
        $position_list = array_column($adv_position, null, 'keywords');
        return $position_list[ $data[ 'adv_key' ] ][ 'ap_name' ] ?? '';
    }

}
