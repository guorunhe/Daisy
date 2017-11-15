<?php
/**
  * @author guorunhe<guorunhe@foxmail.com>
  * @date   17/11/05
  */

namespace core; // 定义命名空间.

use core\Config;
use core\Parser;

/**
  * 试图类.
  */
class View
{
    public $vars = [];

    function __construct($vars = [])
    {
        if (!is_dir(Config::get('cache_path')) || !is_dir(Config::get('compile_path')) || !is_dir(Config::get('view_path'))) {
            exit('该路径不存在.');
        }
        $this->vars = $vars;
    }

    public function display($file)
    {
        $tpl_file = Config::get('view_path') . $file .Config::get('view_suffix');
        if (!file_exists($tpl_file)) {
            exit('模板文件不存在.');
        }

        // 编译文件(文件名用MD5加密加上原始文件名).
        $parser_file = Config::get('compile_path') . md5("$file") . $file . '.php';
        // 缓存文件(缓存前缀加原文件名).
        $cache_file = Config::get('cache_path') . Config::get('cache_prefix') . $file . '.html';
        // 是否开启了自动缓存.
        if (Config::get('auto_cache')) {
            if (file_exists($cache_file) && file_exists($parser_file)) {
                if (filemtime($cache_file) >= filemtime($parser_file) && filemtime($parser_file) >= filemtime($tpl_file)) {
                    return include $cache_file;
                }
            }
        }

        // 是否需要重新编译模板.
        if (!file_exists($parser_file) || filemtime($parser_file) < filemtime($tpl_file)) {
            $parser = new Parser($tpl_file);
            $parser->compile($parser_file);
        }
        include $parser_file;
        
        if (Config::get('auto_cache')) {
            file_put_contents($cache_file, ob_get_contents());
            ob_end_clean();
            return include $cache_file;
        }
    }

}
