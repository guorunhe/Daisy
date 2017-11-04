<?php
/**
  * @author guorunhe<guorunhe@foxmail.com>
  * @date   17/11/05
  */

namespace core; // 定义命名空间.

/**
  * 路由类.
  */
class Router
{
    public $url_query; // URL串.
    public $url_type;  // UTL模式.
    public $route_url = []; // URL数组.
    
    function __construct()
    {
        $this->url_query = parse_url($_SERVER['REQUEST_URI']);
    }

    // 设置URL模式
    public function setUrlType($url_type = 2)
    {
        if ($url_type > 0 && $url_type < 3) {
            $this->url_type = $url_type;
        } else {
            exit('指定URL不存在.');
        }
    }

    // 获取URL数组.
    public function getUrlArray()
    {
        $this->makeUrl();
        return $this->route_url;
    }

    // 处理URl
    public function makeUrl()
    {
        switch ($this->url_type) {
            case 1:
                $this->queryToArray();
                break;
            case 2:
                $this->pathinfoToArray();
                break;
        }
    }

    // 将参数形式转为数组.
    public function queryToArray()
    {
        $arr = !empty($this->url_query['query']) ? explode('&', $this->url_query['query']) : [];
        $array = $tmp = [];
        if (count($arr) > 0) {
            foreach ($arr as $item) {
                $tmp = explode('=', $item);
                $array[$tmp[0]] = $tmp[1];
            }
            if (isset($array['module'])) {
                $this->route_url['module'] = $array['module'];
                unset($array['module']);
            }
            if (isset($array['controller'])) {
                $this->route_url['controller'] = $array['controller'];
                unset($array['controller']);
            }
            if (isset($array['action'])) {
                $this->route_url['action'] = $array['action'];
                unset($array['action']);
            }
            if (isset($this->route_url['action']) && strpos($this->route_url['action'], '.')) {
                if (explode('.', $this->route_url['action'])[1] != Config::get('url_html_suffix')) {
                    exit('后缀错误.');
                } else {
                    $this->route_url['action'] = explode('.', $this->route_url['action'])[0];
                }
            }
        } else {
            $this->route_url = [];
        }
    }

    // 将pathinfo转为数组.
    public function pathinfoToArray()
    {
        $arr = !empty($this->url_query['path']) ? explode('/', $this->url_query['path']) : [];
        if (count($arr) > 0) {
            if ($arr[1] == 'index.php') {
                if (isset($arr[2]) && !empty($arr[2])) {
                    $this->route_url['module'] = $arr[2];
                }
                if (isset($arr[3]) && !empty($arr[3])) {
                    $this->route_url['controller'] = $arr[3];
                }
                if (isset($arr[4]) && !empty($arr[4])) {
                    $this->route_url['action'] = $arr[4];
                }

                if (isset($this->route_url['action']) && strpos($this->route_url['action'], '.')) {
                    if (explode('.', $this->route_url['action'])[1] != Config::get('url_html_suffix')) {
                        exit('不正确的URL');
                    } else {
                        $this->route_url['action'] = explode('.', $this->route_url['action'])[0];
                    }
                }
            } else {
                if (isset($arr[1]) && !empty($arr[1])) {
                    $this->route_url['module'] = $arr[1];
                }
                if (isset($arr[2]) && !empty($arr[2])) {
                    $this->route_url['controller'] = $arr[2];
                }
                if (isset($arr[3]) && !empty($arr[3])) {
                    $this->route_url['action'] = $arr[3];
                }
            }
        } else {
            $this->route_url = [];
        }
    }

}
