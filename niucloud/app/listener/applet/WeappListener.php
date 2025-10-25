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


namespace app\listener\applet;


class WeappListener
{
    /**
     * 返回待替换的文件以及属性
     * @param array $data
     * @return array[]|void
     */
    public function handle(array $data)
    {
        $type = $data['type'];
        if ($type == 'weapp') {
            return [
                [
                    'path' => 'utils/request.js',
                    'variable' => [
                        '{{$baseUrl}}' => (string)url('/api/', [], '', true),
                    ],
                ],
                [
                    'path' => 'utils/common.js',
                    'variable' => [
                        '{{$imgUrl}}' => (string)url('/', [], '', true),
                    ],
                ]
            ];
        }
    }
}