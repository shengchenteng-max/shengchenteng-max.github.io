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

namespace app\service\core\member;

use app\job\member\MemberGiftGrantJob;
use app\model\member\Member;
use app\model\member\MemberLevel;
use core\base\BaseCoreService;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Cache;

/**
 * 会员等级服务层
 * Class CoreMemberAccountService
 * @package app\service\core\member
 */
class CoreMemberLevelService extends BaseCoreService
{
    protected static $cache_tag_name = 'member_level_cache';

    public function __construct()
    {
        parent::__construct();
        $this->model = new MemberLevel();
    }

    /**
     * 获取全部会员等级
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAll()
    {
        $cache_name = 'member_level_all';
        return cache_remember(
            $cache_name,
            function() {
                $field = 'level_id, level_name, growth,level_benefits,level_gifts';
                return $this->model->where([ ['level_id', '>', 0] ])->field($field)->order('growth asc')->select()->toArray();
            },
            self::$cache_tag_name
        );
    }

    /**
     * 清理站点会员等级缓存
     * @return true
     */
    public function clearCache()
    {
        Cache::tag(self::$cache_tag_name)->clear();
        return true;
    }

    /**
     * 会员检测升级
     * @param $member_id
     * @return void
     */
    public function checkLevelUpgrade($member_id) {
        $member = (new Member())->where([ ['member_id', '=', $member_id ] ])->with('member_level_data')->field('member_id,growth,member_level')->findOrEmpty();
        if ($member->isEmpty()) return true;

        $condition = [
            ['growth', '<=', $member['growth'] ],
        ];
        if (isset($member['member_level_data']) && !empty($member['member_level_data'])) {
            $condition[] = ['growth', '>', $member['member_level_data']['growth'] ];
        }

        $upgrade = $this->model->where($condition)->field('level_id,level_gifts,growth')->order('growth asc')->select()->toArray();
        if (empty($upgrade)) return true;

        // 发放等级礼包
        foreach ($upgrade as $level) {
            MemberGiftGrantJob::dispatch([
                'member_id' => $member_id,
                'gift' => $level['level_gifts'],
                'param' => [
                    'from_type' => 'level_upgrade',
                    'memo' => '会员升级奖励'
                ]
            ]);
        }

        $level = end($upgrade);
        $member->member_level = $level['level_id'];
        $member->save();

        event('MemberLevelUpgrade', ['member_id' => $member_id, 'level' => $level]);

        return true;
    }
}
