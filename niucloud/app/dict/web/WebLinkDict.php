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

namespace app\dict\web;

use core\dict\DictLoader;

/**
 * 电脑端页面链接
 * Class WebLinkDict
 * @package app\dict\diy
 */
class WebLinkDict
{
    /**
     * 查询存在页面路由的应用插件列表 query 格式：'query' => 'addon'
     * 查询插件的链接列表，包括系统的链接 addon 格式：'addon' => 'shop'
     * @param array $params
     * @return array|null
     */
    public static function getLink($params = [])
    {
        $system_links = [
            'SYSTEM_LINK' => [
                'title' => get_lang('dict_diy.system_link'),
                'addon_info' => [
                    'title' => '系统',
                    'key' => 'app'
                ],
                'child_list' => [
                    [
                        'name' => 'INDEX',
                        'title' => get_lang('dict_diy.system_web_index'),
                        'url' => '/app/index',
                        'is_share' => 1,
                        'action' => '' // 默认空，decorate 表示支持装修
                    ],
                ]
            ],
            'MEMBER_LINK' => [
                'title' => get_lang('dict_diy.member_link'),
                'addon_info' => [
                    'title' => '系统',
                    'key' => 'app'
                ],
                'child_list' => [
                    [
                        'name' => 'AUTH_LOGIN',
                        'title' => get_lang('dict_diy.auth_login'),
                        'url' => '/auth/login',
                        'is_share' => 1,
                        'action' => ''
                    ],
                    [
                        'name' => 'AUTH_REGISTER',
                        'title' => get_lang('dict_diy.auth_register'),
                        'url' => '/auth/register',
                        'is_share' => 1,
                        'action' => ''
                    ],
                    [
                        'name' => 'AUTH_BIND',
                        'title' => get_lang('dict_diy.auth_bind'),
                        'url' => '/auth/bind',
                        'is_share' => 1,
                        'action' => ''
                    ],
                    [
                        'name' => 'MEMBER_CENTER',
                        'title' => get_lang('dict_diy.member_my_personal'),
                        'url' => '/member/center',
                        'is_share' => 1,
                        'action' => ''
                    ],
                    [
                        'name' => 'MEMBER_BALANCE',
                        'title' => get_lang('dict_diy.member_my_balance'),
                        'url' => '/member/balance',
                        'is_share' => 1,
                        'action' => ''
                    ],
                    [
                        'name' => 'MEMBER_POINT',
                        'title' => get_lang('dict_diy.member_my_point'),
                        'url' => '/member/point',
                        'is_share' => 1,
                        'action' => ''
                    ],
                    [
                        'name' => 'MEMBER_ADDRESS',
                        'title' => get_lang('dict_diy.member_my_address'),
                        'url' => '/member/address_list',
                        'is_share' => 1,
                        'action' => ''
                    ]
                ]
            ],
            'DIY_LINK' => [
                'title' => get_lang('dict_diy.diy_link'),
                'addon_info' => [
                    'title' => '系统',
                    'key' => 'app'
                ],
                'child_list' => []
            ]
        ];

        // 查询存在页面路由的应用插件列表
        if (!empty($params[ 'query' ]) && $params[ 'query' ] == 'addon') {
            $system = [
                'app' => [
                    'title' => '系统',
                    'key' => 'app'
                ]
            ];
            $addons = (new DictLoader("WebLink"))->load([ 'data' => $system, 'params' => $params ]);
            $app = array_merge($system, $addons);
            return $app;
        } else {
            return (new DictLoader("WebLink"))->load([ 'data' => $system_links, 'params' => $params ]);
        }
    }

}
