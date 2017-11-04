<?php
/**
  * @author guorunhe<guorunhe@foxmail.com>
  * @date   17/11/05
  */

namespace core; // 定义命名空间.

use core\View;
/**
  * 控制器类.
  */
class Controller
{
    protected $vars = [];   // 模板变量.
    protected $tpl;     // 视图模板.

    // 变量赋值.
    final protected function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->vars = array_merge($this->vars, $name);
            return $this;
        } else {
            $this->vars[$name] = $value;
        }
    }
    
    // 设置模板.
    final public function setTpl($tpl = '')
    {
        $this->tpl = $tpl;
    }

    // 模板展示.
    final protected function display()
    {
        $view = new View($this->vars);
        $view->display($this->tpl);
    }

}
