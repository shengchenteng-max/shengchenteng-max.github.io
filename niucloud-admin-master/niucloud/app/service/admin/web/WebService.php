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

namespace app\service\admin\web;

use app\dict\web\WebLinkDict;
use core\base\BaseAdminService;


/**
 * web端基础服务层
 * Class WebService
 * @package app\service\admin\web
 */
class WebService extends BaseAdminService
{
    /**
     * 获取web端链接配置
     * @return array
     */
    public function getLink()
    {

        $link = WebLinkDict::getLink();
        foreach ($link as $k => $v) {
            $link[ $k ][ 'name' ] = $k;
            if (!empty($v[ 'child_list' ])) {
                foreach ($v[ 'child_list' ] as $ck => $cv) {
                    $link[ $k ][ 'child_list' ][ $ck ][ 'parent' ] = $k;
                }
            }

        }
        return $link;
    }
}
