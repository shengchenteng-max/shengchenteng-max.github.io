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

use core\base\BaseModel;

/**
 * 友情链接模型
 * Class FriendlyLink
 * @package app\model\web
 */
class FriendlyLink extends BaseModel
{


    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'web_friendly_link';


    /**
     * 搜索器:友情链接标题
     * @param $value
     * @param $data
     */
    public function searchLinkTitleAttr($query, $value, $data)
    {
        if ($value) {
            $query->where("link_title", 'like', '%' . $value . '%');
        }
    }


}
