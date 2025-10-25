<?php

namespace app\upgrade\v144;

use app\model\sys\Poster;
use app\service\core\poster\CorePosterService;

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

        $poster_model = new Poster();
        $poster = new CorePosterService();
        $template = $poster->getTemplateList('', 'friendspay')[ 0 ];

        $poster_model->where([ [ 'type', '=', 'friendspay' ] ])->delete();
        // 创建默认找朋友帮忙付海报
        $poster->add('', [
            'name' => $template[ 'name' ],
            'type' => $template[ 'type' ],
            'value' => $template[ 'data' ],
            'status' => 1,
            'is_default' => 1
        ]);
    }

}
