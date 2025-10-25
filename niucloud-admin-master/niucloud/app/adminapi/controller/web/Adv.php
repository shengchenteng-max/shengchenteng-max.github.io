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

namespace app\adminapi\controller\web;

use app\dict\web\AdvPositionDict;
use app\service\admin\web\AdvService;
use core\base\BaseAdminController;
use think\Response;


/**
 * 广告管理
 * Class Nav
 * @package app\adminapi\controller\web
 */
class Adv extends BaseAdminController
{

    /**
     * 广告位
     * @return \think\Response
     */
    public function advPosition()
    {
        return success(AdvPositionDict::getAdvPosition());
    }

    /**
     * 获取广告分页列表
     * @return \think\Response
     */
    public function pages()
    {
        $data = $this->request->params([
            [ 'adv_key', '' ]
        ]);
        return success(( new AdvService() )->getPage($data));
    }

    /**
     * 获取广告列表
     * @return \think\Response
     */
    public function lists()
    {
        $data = $this->request->params([
            [ 'adv_key', '' ]
        ]);
        return success(( new AdvService() )->getList($data));
    }

    /**
     * 广告详情
     * @param int $id
     * @return \think\Response
     */
    public function info(int $id)
    {
        return success(( new AdvService() )->getInfo($id));
    }

    /**
     * 添加广告
     * @return \think\Response
     */
    public function add()
    {
        $data = $this->request->params([
            [ 'adv_key', '' ],
            [ 'adv_title', '' ],
            [ 'adv_url', '' ],
            [ 'adv_image', '' ],
            [ 'sort', 0 ],
            [ 'background', '#FFFFFF' ],
        ]);
        $id = ( new AdvService() )->add($data);
        return success('ADD_SUCCESS', [ 'id' => $id ]);
    }

    /**
     * 广告编辑
     * @param $id  广告id
     * @return \think\Response
     */
    public function edit($id)
    {
        $data = $this->request->params([
            [ 'adv_key', '' ],
            [ 'adv_title', '' ],
            [ 'adv_url', '' ],
            [ 'adv_image', '' ],
            [ 'sort', 0 ],
            [ 'background', '#FFFFFF' ],
        ]);
        ( new AdvService() )->edit($id, $data);
        return success('EDIT_SUCCESS');
    }

    /**
     * 广告删除
     * @param int $id
     * @return Response
     */
    public function del(int $id)
    {
        ( new AdvService() )->del($id);
        return success('DELETE_SUCCESS');
    }

    /**
     * 修改广告位排序号
     * @return \think\Response
     */
    public function editSort()
    {
        $data = $this->request->params([
            [ 'id', '' ],
            [ 'sort', '' ],
        ]);
        ( new AdvService() )->editSort($data);
        return success('SUCCESS');
    }

}
