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

namespace app\service\core\sys;

use app\dict\sys\AgreementDict;
use app\model\sys\SysAgreement;
use core\base\BaseCoreService;
use core\exception\CommonException;

/**
 * 配置服务层
 * Class CoreAgreementService
 * @package app\service\core\sys
 */
class CoreAgreementService extends BaseCoreService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new SysAgreement();
    }

    /**
     * 获取协议内容
     * @param string $key
     * @return array
     */
    public function getAgreement(string $key)
    {
        if(!array_key_exists($key, AgreementDict::getType())) throw new CommonException('AGREEMENT_TYPE_NOT_EXIST');
        $where = array(
            ['agreement_key', '=', $key],
        );
        $info = $this->model->where($where)->field('agreement_key, title, content, create_time, update_time')->append(['agreement_key_name'])->findOrEmpty()->toArray();
        if(empty($info))
        {
            $info = [
                'agreement_key' => $key,
                'agreement_key_name' => AgreementDict::getType()[$key] ?? '',
                'title' => '',
                'content' => '',
                'create_time' => '',
                'update_time' => ''
            ];
        }
        return $info;
    }

    public function find(string $key)
    {
        if(!array_key_exists($key, AgreementDict::getType())) throw new CommonException('AGREEMENT_TYPE_NOT_EXIST');
        $where = array(
            ['agreement_key', '=', $key],
        );
        return $this->model->where($where)->findOrEmpty();
    }
    /**
     * 设置协议
     * @param string $key
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function setAgreement(string $key, string $title, string $content)
    {
        if(!array_key_exists($key, AgreementDict::getType())) throw new CommonException('AGREEMENT_TYPE_NOT_EXIST');
        $where = array(
            ['agreement_key', '=', $key],
        );
        $data = array(
            'agreement_key' => $key,
            'title' => $title,
            'content' => $content
        );
        $agreement = $this->find($key);
        if($agreement->isEmpty()){
            $data['create_time'] = time();
            $res = $this->model->create($data);
        }else{
            $data['update_time'] = time();
            $res = $this->model->where($where)->save($data);
        }

        return $res;
    }
}
