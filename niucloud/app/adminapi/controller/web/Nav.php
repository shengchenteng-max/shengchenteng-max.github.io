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

use app\service\admin\web\NavService;
use core\base\BaseAdminController;
use think\Response;


/**
 * 电脑端导航
 * Class Nav
 * @package app\adminapi\controller\web
 */
class Nav extends BaseAdminController
{

    /**
     * 获取首页导航分页列表
     * @return \think\Response
     */
    public function pages()
    {
        $data = $this->request->params([
            [ "nav_title", "" ],
        ]);
        return success(( new NavService() )->getPage($data));
    }

    /**
     * 获取首页导航列表
     * @return \think\Response
     */
    public function lists()
    {
        $data = $this->request->params([
            [ "nav_title", "" ]
        ]);
        return success(( new NavService() )->getList($data));
    }

    /**
     * 首页导航详情
     * @param int $id
     * @return \think\Response
     */
    public function info(int $id)
    {
        return success(( new NavService() )->getInfo($id));
    }

    /**
     * 添加首页导航
     * @return \think\Response
     */
    public function add()
    {
        $data = $this->request->params([
            [ "nav_title", "" ],
            [ "nav_url", "" ],
            [ "sort", "" ],
            [ "is_blank", "" ],
            [ "is_show", "" ],
        ]);
        $id = ( new NavService() )->add($data);
        return success('ADD_SUCCESS', [ 'id' => $id ]);
    }

    /**
     * 首页导航编辑
     * @param $id  首页导航id
     * @return \think\Response
     */
    public function edit($id)
    {
        $data = $this->request->params([
            [ "nav_title", "" ],
            [ "nav_url", "" ],
            [ "sort", "" ],
            [ "is_blank", "" ],
            [ "is_show", "" ],
        ]);
        ( new NavService() )->edit($id, $data);
        return success('EDIT_SUCCESS');
    }

    /**
     * 首页导航删除
     * @param int $id 首页导航id
     * @return Response
     */
    public function del(int $id)
    {
        ( new NavService() )->del($id);
        return success('DELETE_SUCCESS');
    }

    /**
     * 修改首页导航排序号
     * @return \think\Response
     */
    public function editSort()
    {
        $data = $this->request->params([
            [ 'id', '' ],
            [ 'sort', '' ],
        ]);
        ( new NavService() )->editSort($data);
        return success('SUCCESS');
    }

}
