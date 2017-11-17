<?php
/**
  * @author guorunhe<guorunhe@foxmail.com>
  * @date 17/11/17
  */
namespace shop\controller;

use core\Controller;
use shop\model\UserModel;
/**
  * index 控制器.
  */
class UserController extends Controller
{
    public function index()
    {
        $model = new UserModel();
        if ($model->insert(['name' => 'hello', 'password' => 'shiyanlou'])) {
            $model->free();
            echo "Success";
        } else {
            $model->free();
            echo "Failed";
        }
    }
}
