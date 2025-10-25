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

namespace app\service\core\stat;

use app\model\stat\StatHour;
use core\base\BaseCoreService;

/**
 * 统计
 */
class CoreStatService extends BaseCoreService
{

    /**
     * 获取统计字段
     * @return mixed
     */
    public function getStatField()
    {
       return event('StatField');
    }

    /**
     * 添加统计
     * @param $param = ['addon' =>, 'date' => ['year' => , 'month'=> , 'day' => , 'hour' => ], 'data' => ['shop_order_money' => 12, 'member' => 12]]
     */
    public function add(array $param)
    {
        $model = new StatHour();
        $condition = [
            ['year', '=', $param['date']['year']],
            ['month', '=', $param['date']['month']],
            ['day', '=', $param['date']['day']],
            ['addon', '=', $param['addon']],
        ];
        $list = $model->where($condition)->field('*')->select()->toArray();
        if(!empty($list)) {
            $list = array_column($list, null, 'field');
        }
        foreach ($param['data'] as $k => $v)
        {
            if(array_key_exists($k, $list))
            {
                //修改
                $field_condition = $condition;
                $field_condition[] = ['field', '=', $k];

                $sum_data = 0;
                for ($i = 0; $i < 24; $i ++)
                {
                    if($param['date']['hour'] == $i )
                    {
                        $list[$k]['hour_'.$i] = $v;
                    }
                    $sum_data += $list[$k]['hour_'.$i];
                }
                $data = [
                    'hour_'.$param['date']['hour'] => $v,
                    'last_time' => time(),
                    'field_total' => $sum_data,
                ];
                $model->where($field_condition)->update($data);

            }else {
                $data = [
                    'year' => $param['date']['year'],
                    'month' => $param['date']['month'],
                    'day' => $param['date']['day'],
                    'addon' =>  $param['addon'],
                    'field' => $k,
                    'hour_'.$param['date']['hour'] => $v,
                    'field_total' => $v,
                    'start_time' => strtotime($param['date']['year'].'-'. $param['date']['month']. '-'.$param['date']['day']. ' '. '00:00:00'),
                    'last_time' => time()
                ];
                $model->create($data);
            }
        }

    }

    public function getLastTime()
    {
        //存取缓存，如果没有缓存，会执行stat_hour,当天数据，最大时间
    }

    /**
     * 获取日统计数据
     * @param $year
     * @param $month
     * @param $day
     * @param $fields
     */
    public function getDayStat($year, $month, $day, $fields)
    {
        $model = new StatHour();
        $condition = [
            ['year', '=', $year],
            ['month', '=', $month],
            ['day', '=', $day],
            ['field', 'in', $fields],
        ];
        $list = $model->where($condition)->field("*")->select()->toArray();
        if(!empty($list))
        {
            $list = array_column($list, null, 'field');
            foreach ($fields as $v)
            {
                if(!array_key_exists($v, $list))
                {
                    $list[$v] = $this->statInit(['year' => $year, 'month' => $month, 'day' => $day, 'field' => $v]);
                }
            }
        }
        return $list;
    }

    /**
     * 获取时间段内数据(无小时统计)
     * @param $start_time
     * @param $end_time
     * @param $fields
     */
    public function getTimePeriodStat($fields, $start_time = 0, $end_time = 0)
    {
        $condition = [
            ['field', 'in', $fields],
        ];
        if(!empty($start_time))
        {
            $condition[] = ['start_time', '>=', $start_time];
        }
        if(!empty($end_time))
        {
            $condition[] = ['start_time', '<', $end_time];
        }

        $field = 'field,sum(field) as sum_field';
        $list = (new StatHour())->where($condition)->field($field)->group('field')->select()->toArray();

        if(!empty($list))
        {
            $list = array_column($list, null, 'field');
            foreach ($fields as $v)
            {
                if(!array_key_exists($v, $list))
                {
                    $list[$v] = ['field' => $v, 'sum_field' => 0];
                }
            }
        }
    }

    /**
     * 获取日统计列表
     * @param $field //单个字段
     * @param $start_time
     * @param $end_time
     */
    public function getDayStatList($field, $start_time, $end_time)
    {
        $condition = [
            ['field', 'i=', $field],
        ];
        if(!empty($start_time))
        {
            $condition[] = ['start_time', '>=', $start_time];
        }
        if(!empty($end_time))
        {
            $condition[] = ['start_time', '<', $end_time];
        }
        $list = (new StatHour())->where($condition)->field('*')->select()->toArray();
        return $list;
    }


    /**
     * 初始化数据
     * @param $data ['year' =>, 'month' => , 'day' => , 'field' => ]
     */
    private function statInit($data)
    {

        return [
            'addon' => $data['addon'] ?? '',
            'field' => $data['field'],
            'field_total' => 0,
            'last_time' => 0,
            'hour_0' => 0,
            'hour_1' => 0,
            'hour_2' => 0,
            'hour_3' => 0,
            'hour_4' => 0,
            'hour_5' => 0,
            'hour_6' => 0,
            'hour_7' => 0,
            'hour_8' => 0,
            'hour_9' => 0,
            'hour_10' => 0,
            'hour_11' => 0,
            'hour_12' => 0,
            'hour_13' => 0,
            'hour_14' => 0,
            'hour_15' => 0,
            'hour_16' => 0,
            'hour_17' => 0,
            'hour_18' => 0,
            'hour_19' => 0,
            'hour_20' => 0,
            'hour_21' => 0,
            'hour_22' => 0,
            'hour_23' => 0,
        ];
    }


}
