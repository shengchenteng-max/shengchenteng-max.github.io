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

use app\model\web\FriendlyLink;
use core\base\BaseApiService;


/**
 * 友情链接服务层
 * Class FloorService
 * @package app\service\api\web
 */
class FriendlyLinkService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new FriendlyLink();
    }

    /**
     * 获取友情链接
     * @param array $where
     * @return array
     */
    public function getList()
    {
        $field = 'id,link_title,link_url,link_pic,sort';
        $order = 'sort desc';
        $list = $this->model->field($field)->where([['is_show', '=', 1]])->order($order)->select()->toArray();
        return $list;
    }

}
