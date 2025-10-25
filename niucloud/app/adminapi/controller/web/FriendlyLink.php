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

use core\base\BaseAdminController;
use app\service\admin\web\FriendlyLinkService;
use think\Response;


/**
 * 友情链接控制器
 * Class FriendlyLink
 * @package app\adminapi\controller\web
 */
class FriendlyLink extends BaseAdminController
{
    /**
     * 获取友情链接列表
     * @return \think\Response
     */
    public function lists()
    {
        $data = $this->request->params([
            [ 'link_title', '' ]
        ]);
        return success(( new FriendlyLinkService() )->getPage($data));
    }

    /**
     * 友情链接详情
     * @param int $id
     * @return \think\Response
     */
    public function info(int $id)
    {
        return success(( new FriendlyLinkService() )->getInfo($id));
    }

    /**
     * 添加友情链接
     * @return \think\Response
     */
    public function add()
    {
        $data = $this->request->params([
            [ 'link_pic', '' ],
            [ 'link_title', '' ],
            [ 'link_url', '' ],
            [ 'sort', 0 ],
            [ 'is_show', 0 ]
        ]);
        $this->validate($data, 'app\validate\web\FriendlyLink.add');
        $id = ( new FriendlyLinkService() )->add($data);
        return success('ADD_SUCCESS', [ 'id' => $id ]);
    }

    /**
     * 友情链接编辑
     * @param int $id 友情链接id
     * @return Response
     */
    public function edit(int $id)
    {
        $data = $this->request->params([
            [ 'link_pic', '' ],
            [ 'link_title', '' ],
            [ 'link_url', '' ],
            [ 'sort', 0 ],
            [ 'is_show', 0 ]
        ]);
        $this->validate($data, 'app\validate\web\FriendlyLink.edit');
        ( new FriendlyLinkService() )->edit($id, $data);
        return success('EDIT_SUCCESS');
    }

    /**
     * 友情链接删除
     * @param int $id 友情链接id
     * @return Response
     */
    public function del(int $id)
    {
        ( new FriendlyLinkService() )->del($id);
        return success('DELETE_SUCCESS');
    }

    /**
     * 修改友情链接排序号
     * @return \think\Response
     */
    public function editSort()
    {
        $data = $this->request->params([
            [ 'id', '' ],
            [ 'sort', '' ],
        ]);
        ( new FriendlyLinkService() )->editSort($data);
        return success('SUCCESS');
    }

}
