<?php

namespace BusyPHP\form;

use BusyPHP\form\app\controller\FormController;
use BusyPHP\Service as BaseService;
use think\Route;

/**
 * Service
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2022 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2022/4/2 7:19 PM Service.php $
 */
class Service extends \think\Service
{
    public function boot()
    {
        $this->registerRoutes(function(Route $route) {
            $actionPattern = '<' . BaseService::ROUTE_VAR_ACTION . '>';
            
            // 后台路由
            if ($this->app->http->getName() === 'admin') {
                $route->rule("plugins_form/{$actionPattern}", FormController::class . "@{$actionPattern}")->append([
                    BaseService::ROUTE_VAR_TYPE    => 'plugin',
                    BaseService::ROUTE_VAR_CONTROL => 'plugins_form',
                ]);
            }
        });
    }
}