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

namespace app\validate\web;

use core\base\BaseValidate;

/**
 * 友情链接验证器
 * Class FriendlyLink
 * @package addon\app\validate\web
 */
class FriendlyLink extends BaseValidate
{

    protected $rule = [
        'link_title' => 'require',
        'link_url' => 'require',
    ];

    protected $message = [
        'link_title.require' => [ 'common_validate.require', [ 'link_title' ] ],
        'link_url.require' => [ 'common_validate.require', [ 'link_url' ] ],
    ];

    protected $scene = [
        "add" => [ 'link_pic', 'link_title', 'link_url', 'is_show' ],
        "edit" => [ 'link_pic', 'link_title', 'link_url', 'is_show' ]
    ];

}
