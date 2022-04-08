<?php
declare(strict_types = 1);

namespace BusyPHP\form\app\controller;

use BusyPHP\app\admin\model\system\plugin\SystemPlugin;
use BusyPHP\contract\abstracts\PluginManager;
use Exception;
use think\Response;

/**
 * 插件管理
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/10 下午10:24 ManagerController.php $
 */
class ManagerController extends PluginManager
{
    /**
     * 创建表SQL
     * @var string[]
     */
    private $createTableSql = [
    ];
    
    /**
     * 删除表SQL
     * @var string[]
     */
    private $deleteTableSql = [
    ];
    
    
    /**
     * 返回模板路径
     * @return string
     */
    protected function viewPath() : string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
    }
    
    
    /**
     * 安装插件
     * @return Response
     * @throws Exception
     */
    public function install() : Response
    {
        $model = SystemPlugin::init();
        $model->startTrans();
        try {
            foreach ($this->deleteTableSql as $item) {
                $this->executeSQL($item);
            }
            
            foreach ($this->createTableSql as $item) {
                $this->executeSQL($item);
            }
            
            $model->setInstall($this->info->package);
            
            $model->commit();
        } catch (Exception $e) {
            $model->rollback();
            
            throw $e;
        }
        
        $this->updateCache();
        $this->logInstall();
        
        return $this->success('安装成功');
    }
    
    
    /**
     * 卸载插件
     * @return Response
     * @throws Exception
     */
    public function uninstall() : Response
    {
        $model = SystemPlugin::init();
        $model->startTrans();
        try {
            foreach ($this->deleteTableSql as $item) {
                $this->executeSQL($item);
            }
            
            $model->setUninstall($this->info->package);
            
            $model->commit();
        } catch (Exception $e) {
            $model->rollback();
            
            throw $e;
        }
        
        $this->updateCache();
        $this->logUninstall();
        
        return $this->success('卸载成功');
    }
    
    
    /**
     * 设置插件
     * @return Response
     * @return Exception
     */
    public function setting() : Response
    {
        return response();
    }
}