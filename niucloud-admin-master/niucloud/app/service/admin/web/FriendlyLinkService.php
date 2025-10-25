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

use app\model\web\FriendlyLink;
use core\base\BaseAdminService;


/**
 * 友情链接服务层
 * Class FriendlyLinkService
 * @package app\service\admin\web
 */
class FriendlyLinkService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new FriendlyLink();
    }

    /**
     * 获取友情链接列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'id,link_pic,link_title,link_url,sort,is_show';
        $order = 'id desc';

        $search_model = $this->model->withSearch([ 'link_title' ], $where)->field($field)->order($order);
        $list = $this->pageQuery($search_model);
        return $list;
    }

    /**
     * 获取友情链接信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'id,link_pic,link_title,link_url,sort,is_show';

        $info = $this->model->field($field)->where([ [ 'id', "=", $id ] ])->findOrEmpty()->toArray();
        return $info;
    }

    /**
     * 添加友情链接
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $res = $this->model->create($data);
        return $res->id;

    }

    /**
     * 友情链接编辑
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function edit(int $id, array $data)
    {

        $this->model->where([ [ 'id', '=', $id ] ])->update($data);
        return true;
    }

    /**
     * 删除友情链接
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        $model = $this->model->where([ [ 'id', '=', $id ] ])->find();
        $res = $model->delete();
        return $res;
    }

    /**
     * 修改友情链接排序号
     * @param array $data
     * @return FriendlyLink|bool
     */
    public function editSort($data)
    {
        return $this->model->where([ [ 'id', '=', $data[ 'id' ] ] ])->update([ 'sort' => $data[ 'sort' ] ]);
    }

}
