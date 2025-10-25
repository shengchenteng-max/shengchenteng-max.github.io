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

use app\dict\web\AdvPositionDict;
use app\model\web\Adv;
use core\base\BaseAdminService;
use core\exception\AdminException;


/**
 * 广告服务层
 */
class AdvService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Adv();
    }

    /**
     * 获取广告列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'adv_id, adv_key, adv_title, adv_url, adv_image, sort, background';
        $order = 'adv_id desc';

        $search_model = $this->model->withSearch([ 'adv_key' ], $where)->field($field)->append([ 'ap_name' ])->order($order);
        $list = $this->pageQuery($search_model);
        return $list;
    }

    /**
     * 获取广告列表
     * @param array $where
     * @param string $field
     * @return array
     */
    public function getList(array $where = [], $field = 'adv_id, adv_key, adv_title, adv_url, adv_image, sort, background')
    {
        $order = 'adv_id desc';
        return $this->model->withSearch([ 'adv_key' ], $where)->field($field)->append([ "ap_name" ])->order($order)->select()->toArray();
    }

    /**
     * 获取广告信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'adv_id, adv_key, adv_title, adv_url, adv_image, sort, background';
        $info = $this->model->field($field)->where([ [ 'adv_id', '=', $id ] ])->append([ "ap_name" ])->findOrEmpty()->toArray();
        return $info;
    }

    /**
     * 添加广告
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $adv_position = AdvPositionDict::getAdvPosition();
        $position_list = array_column($adv_position, null, 'keywords');
        if (!array_key_exists($data[ 'adv_key' ], $position_list)) throw new AdminException("WEB_ADV_POSITION_NOT_EXIST");
        $res = $this->model->create($data);
        return $res->adv_id;
    }

    /**
     * 广告编辑
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function edit(int $id, array $data)
    {
        $adv_position = AdvPositionDict::getAdvPosition();
        $position_list = array_column($adv_position, null, 'keywords');
        if (!array_key_exists($data[ 'adv_key' ], $position_list)) throw new AdminException("WEB_ADV_POSITION_NOT_EXIST");
        $this->model->where([ [ 'adv_id', '=', $id ] ])->update($data);
        return true;
    }

    /**
     * 删除广告
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        $model = $this->model->where([ [ 'adv_id', '=', $id ] ])->find();
        $res = $model->delete();
        return $res;
    }

    /**
     * 修改广告位排序号
     * @param array $data
     * @return Adv|bool
     */
    public function editSort($data)
    {
        return $this->model->where([ [ 'adv_id', '=', $data[ 'id' ] ] ])->update([ 'sort' => $data[ 'sort' ] ]);
    }

}
