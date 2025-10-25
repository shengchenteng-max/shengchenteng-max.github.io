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

use app\model\web\Nav;
use core\base\BaseAdminService;


/**
 * 首页导航服务层
 * Class WebService
 * @package app\service\admin\web
 */
class NavService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Nav();
    }


    /**
     * 获取首页导航列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'id, nav_title, nav_url, sort, is_blank, create_time, update_time, is_show';
        $order = 'create_time desc';

        $search_model = $this->model->withSearch([ "nav_title" ], $where)->field($field)->order($order);
        $list = $this->pageQuery($search_model);
        return $list;
    }

    /**
     * 获取首页导航列表
     * @param array $where
     * @param string $field
     * @return array
     */
    public function getList(array $where = [], $field = 'id, nav_title, nav_url, sort, is_blank, create_time, update_time, is_show')
    {
        $order = "create_time desc";
        return $this->model->withSearch([ "nav_title" ], $where)->field($field)->select()->order($order)->toArray();
    }

    /**
     * 获取首页导航信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'id, nav_title, nav_url, sort, is_blank, create_time, update_time, is_show';
        $info = $this->model->field($field)->where([ [ 'id', '=', $id ] ])->findOrEmpty()->toArray();
        return $info;
    }

    /**
     * 添加首页导航
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data[ 'create_time' ] = time();
        $res = $this->model->create($data);
        return $res->id;

    }

    /**
     * 首页导航编辑
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function edit(int $id, array $data)
    {
        $data[ 'update_time' ] = time();
        $this->model->where([ [ 'id', '=', $id ] ])->update($data);
        return true;
    }

    /**
     * 删除首页导航
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
     * 修改首页导航排序号
     * @param array $data
     * @return Nav|bool
     */
    public function editSort($data)
    {
        return $this->model->where([ [ 'id', '=', $data[ 'id' ] ] ])->update([ 'sort' => $data[ 'sort' ] ]);
    }
}
