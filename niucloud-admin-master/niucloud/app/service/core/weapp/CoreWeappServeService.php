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

namespace app\service\core\weapp;

use core\base\BaseCoreService;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;

/**
 * 微信服务提供
 * Class CoreWechatServeService
 * @package app\service\core\wechat
 */
class CoreWeappServeService extends BaseCoreService
{
    /**
     * 事件推送
     * @return Response
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws InvalidConfigException
     */
    public function serve()
    {
        $app = CoreWeappService::app();
        $server = $app->getServer();
        $server->with(function($message, \Closure $next) {

        });
        $response = $server->serve();
        return $response;

    }

}
