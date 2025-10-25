<?php
declare (strict_types=1);
namespace app\command\schedule;

use app\dict\schedule\ScheduleDict;
use app\service\core\schedule\CoreScheduleService;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Run extends Command
{
    public function configure()
    {
        // 指令配置
        $this->setName('cron:run')
            ->setDescription('定时任务。');
    }

    /**
     * 执行任务
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        $output->writeln('['.date('Y-m-d H:i:s').']'." Schedule Starting...");
        $now_time = time();
        $core_schedule_service = new CoreScheduleService();
        //查询所有的计划任务
        $task_list = $core_schedule_service->getList(['status' => ScheduleDict::ON]);
        $output->writeln('[' . date('Y-m-d H:i:s') . ']' . " Schedule Started.");
        foreach ($task_list as $item) {
            $next_time = $item['next_time'];
            if(!is_int($next_time)) $next_time = strtotime($next_time);
            if ($next_time < $now_time) {
                $core_schedule_service->execute($item, $output, $now_time);
            }
        }
        $output->writeln('[' . date('Y-m-d H:i:s') . ']' . " Schedule end.");
    }
}
