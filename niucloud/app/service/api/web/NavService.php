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

use app\model\web\Nav;
use core\base\BaseApiService;


/**
 * 导航服务层
 * Class FloorService
 * @package app\service\api\web
 */
class NavService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Nav();
    }

    /**
     * 获取导航列表
     * @param array $where
     * @return array
     */
    public function getList()
    {
        $field = 'id,nav_title,nav_url,sort,is_blank';
        $order = 'sort desc';
        $list = $this->model->field($field)->where([ [ 'is_show', '=', 1 ] ])->order($order)->select()->toArray();
        return $list;
    }

}
