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
class TestController extends Controller
{
    public function test()
    {
        file_put_contents('/tmp/guorh.log', 'nihao');
        $this->assign('name', 'Daisy---毕美丽');
        $this->display();
    }
}
