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

namespace app\service\api\web;

use app\dict\web\AdvPositionDict;
use app\model\web\Adv;
use core\base\BaseApiService;
use core\exception\ApiException;

/**
 * 广告服务层
 * Class DiyService
 * @package app\service\api\diy
 */
class AdvService extends BaseApiService
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Adv();
    }

    /**
     * 获取广告信息
     * @param string $adv_key
     * @return mixed
     */
    public function getInfo(string $adv_key)
    {
        $adv_position = AdvPositionDict::getAdvPosition();
        $position_list = array_column($adv_position, null, 'keywords');
        if (!array_key_exists($adv_key, $position_list)) throw new ApiException("WEB_ADV_POSITION_NOT_EXIST");
        $info = $position_list[ $adv_key ];
        $info[ 'adv_list' ] = $this->model->where([ [ 'adv_key', '=', $adv_key ] ])->order('sort desc')->select()->toArray();
        return $info;
    }

}
