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
 * 首页导航（电脑端）
 * Class Nav
 * @package app\model\web
 */
class Nav extends BaseModel
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
    protected $name = 'web_nav';

    // 设置json类型字段
    protected $json = ['nav_url'];
    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

    /**
     * 关键字搜索
     * @param $query
     * @param $value
     * @param $data
     */
    public function searchNavTitleAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('nav_title', 'like', '%' . $value . '%');
        }
    }

}
