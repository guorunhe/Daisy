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
      * return void
      */
    public static function register()
    {
        spl_autoload_register('core\\Loader::loadClass');
    }

    /**
      * 添加命名空间前缀与文件base目录对.
      *
      * @param string $prefix   命名空间前缀.
      * @param string $base_dir 命名空间中类文件的基目录.
      * @param bool   $prepend  为true时，将基目录插入到最前，这将让其作为第一个被搜索到，否则插入到最后.
      *
      * return void
      */
    public static function addNamespace($prefix, $base_dir, $prepend = false)
    {
        // 规范化命名空间前缀.
        $prefix = trim($prefix, '\\') . '\\';

        // 规范化文件基目录.
        $base_dir = rtrim($base_dir, '/') . DIRECTORY_SEPARATOR;
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

        // 初始化命名空间前缀数组.
        if (isset(self::$prefixes[$prefix]) === false) {
            self::$prefixes[$prefix] = [];
        }

        // 将命名空间前缀文件基目录对插入保存数组.
        if ($prepend) {
            array_unshift(self::$prefixes[$prefix], $base_dir);
        } else {
            array_push(self::$prefixes[$prefix], $base_dir);
        }
    }

    /**
      * 由类名载入相应文件.
      *
      * @param string $class 完整的类名.
      *
      * return mixed 成功载入则返回载入的文件名，否则返回false
      */
    public static function loadClass($class)
    {
        // 当前命名空间前缀.
        $prefix = $class;

        // 从后面开始遍历完全合格类名中的命名空间名称，来查找映射的文件.
        while (false !== $pos = strrpos($prefix, '\\')) {
            // 保留命名空间前缀中尾部的分隔符.
            $prefix = substr($class, 0, $pos + 1);

            // 剩余的就是相对类名称.
            $relative_class = substr($class, $pos + 1);

            if (in_array('model', $prefixArr = explode('\\', $prefix))) {
                $prefix = $prefixArr[0] . '\\';
                $relative_class = $prefixArr[1] . '\\' . $relative_class;
            }

            // 利用命名空间前缀和相对类名来加载映射文件.
            $mapped_file = self::loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }

            // 删除命名空间前缀尾部的分隔符，以便用于下一次strrpos（）迭代.
            $prefix = rtrim($prefix, '\\');
        }

        // 找不到相应文件.
        return false;
    }

    /**
      * 根据命名空间前缀和相对类来加载文件.
      *
      * @param string $prefix
      * @param string $relative_class
      *
      * return mixed bool
      */
    protected static function loadMappedFile($prefix, $relative_class)
    {
        // 命名空间前缀中有base目录.
        foreach (self::$prefixes[$prefix] as $base_dir) {
            // 用base目录替代命名空间前缀.
            // 在相对类名中用目录分隔符'/'来替换命名空间分隔符'\'
            // 在后面追加.php组成$file的绝对路径.
            $file = $base_dir
                . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class)
                . '.php';
            $file = $base_dir
                . str_replace('\\', '/', $relative_class)
                . '.php';

            // 当文件存在,载入.
            if (self::requireFile($file)) {
                // 完成载入.
                return $file;
            }
        }

        // 找不到相应文件.
        return false;
    }

    /**
      * 载入文件.
      *
      * @param string $file 需要载入的文件.
      *
      * return bool
      */
    protected static function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }

}
