<?php

namespace BusyPHP\form\app\controller;

use BusyPHP\app\admin\controller\AdminController;

class FormController extends AdminController
{
    public function index()
    {
        return $this->display();
    }
    
    
    protected function display($template = '', $charset = 'utf-8', $contentType = '', $content = '')
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'form' . DIRECTORY_SEPARATOR;
        if ($template) {
            $template = $dir . $template . '.html';
        } else {
            $template = $dir . $this->request->action() . '.html';
        }
        
        return parent::display($template, $charset, $contentType, $content);
    }
}