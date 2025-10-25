<?php

namespace app\upgrade\v130;

use app\model\diy\Diy;
use app\service\admin\diy\DiyService;
use think\facade\Db;

class Upgrade
{

    public function handle()
    {
        $this->handleDiyData();
    }

    /**
     * 处理自定义数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function handleDiyData()
    {
        $diy_model = new Diy();
        $where = [
            [ 'value', '<>', '' ]
        ];
        $field = 'id,name,title,template,value';
        $list = $diy_model->where($where)->field($field)->select()->toArray();

        $diy_service = new DiyService();
        $shop_member_index_template = $diy_service->getFirstPageData('DIY_SHOP_MEMBER_INDEX', 'shop');

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $diy_data = json_decode($v[ 'value' ], true);

                if ($v[ 'name' ] == 'DIY_SHOP_MEMBER_INDEX') {
                    $diy_data = $shop_member_index_template[ 'data' ];
                } else {
                    $diy_data[ 'global' ][ 'topStatusBar' ] = [
                        'isShow' => true,
                        'bgColor' => "#ffffff",
                        'isTransparent' => false,
                        'style' => 'style-1',
                        'styleName' => '风格1',
                        'textColor' => "#333333",
                        'textAlign' => 'center',
                        'inputPlaceholder' => '请输入搜索关键词',
                        'imgUrl' => '',
                        'link' => [
                            'name' => ""
                        ]
                    ];

                    if ($v[ 'name' ] == 'DIY_SHOP_INDEX' && $v[ 'template' ] == 'shop_index_style1') {
                        $diy_data[ 'global' ][ 'topStatusBar' ][ 'isShow' ] = false;
                        $diy_data[ 'global' ][ 'topStatusBar' ][ 'style' ] = 'style-6';
                        $diy_data[ 'global' ][ 'topStatusBar' ][ 'styleName' ] = '风格6';
                    }
                }

                $diy_data = json_encode($diy_data);
                $diy_model->where([ [ 'id', '=', $v[ 'id' ] ] ])->update([ 'value' => $diy_data ]);
            }
        }

        // 赋值 页面名称（用于后台展示）
        $diy_model->where([ [ 'page_title', '=', '' ], ])->update([ 'page_title' => Db::raw('title') ]);
    }

}