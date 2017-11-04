<?php
/**
  * @author guorunhe<guorunhe@foxmail.com>
  * @date   17/11/05
  */
namespace core;

class Loader
{
    protected static $prefixes = [];

    /**
      * 在SPL自动加载器栈中注册加载器.
      *
      * @rturn void
      */
    public static function register()
    {
        spl_autoload_register('core\\Loader::loadClass');
    }
}
