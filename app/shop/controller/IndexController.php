<?php
/**
  * @author guorunhe<guorunhe@foxmail.com>
  * @date 17/11/12
  */
namespace shop\controller;

use core\Controller;
/**
  * index 控制器.
  */
class IndexController extends Controller
{
    public function index()
    {
        $this->assign('name', 'Daisy---毕美丽');
        $this->display();
    }
}
