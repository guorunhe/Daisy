<?php
/**
  * @author guorunhe<guorunhe@foxmail.com>
  * @date   17/11/05
  */

namespace core; // 定义命名空间.

/**
  * 解析类.
  */
class Parser
{
    private $content;
    function __construct($file)
    {
        $this->content = file_get_contents($file);
        if (!$this->content) {
            exit('模板文件读取失败.');
        }
    }

    private function parVar()
    {
        $patter = '/\{\$([\w]+)\}/';
        $repVar = preg_match($patter, $this->content);
        if ($repVar) {
            $this->content = preg_replace($patter, "<?php echo \$this->vars['$1']; ?>", $this->content);
        }
    }

    // private function parIf()
    public function compile($parser_file) {
        $this->parVar();
        file_put_contents($parser_file, $this->content);
    }

}
