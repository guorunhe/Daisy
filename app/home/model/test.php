<?php
include_once '../lib/PHPExcel.php';

echo var_export(['dfdf', 'ddf']);
// echo var_export([$argv[1], $argv[2]]);
// exit;
$file = getRealPath($argv[1], $argv[2]);
$objPHPExcel = new \PHPExcel();
$reader = \PHPExcel_IOFactory::createReader('Excel2007');
$PHPExcel = $reader->load($file);
$sheet = $PHPExcel->getSheet(0);
$row = $sheet->getHighestRow();
$column = $sheet->getHighestColumn();
$fileSize = filesize($file);
// echo var_export([$sheet, $count, $fileSize]);
$key = ['name', 'mobile', 'email', 'organization', 'dept', 'jobNumber'];
for ($i = 'A'; $i <= 'F'; $i++) {
    $title[] = $sheet->getCell($i . 2)->getValue();
    $letter[] = $i;
}
for ($j = 3; $j <= $row; $j++) {
    for ($i = 'A', $k = 0; $i <= 'F'; $i++, $k++) {
        $data[$j][$key[$k]] = $sheet->getCell($i . $j)->getValue();
    }
}
echo implode(',', $letter);
echo implode(',', $title);
exit;
echo var_export([$title, $leter], true);
exit;
$data = array_merge($data, []);
$newDir = '/usr/local/var/www/guorh';
// `cd $newDir && rm -rf $argv[2]`;
echo var_export($data);
exit;
// http://ykj-esn-test.oss-cn-beijing.aliyuncs.com/199129/4531/201711/9/1510198400ThZY.xlsx
// 107719
function getRealPath($filePath, $fileId)
{
    $newDir = '/usr/local/var/www/guorh/' . $fileId . '/';
    if (!is_dir($newDir)) {
        $createFlag = mkdir($newDir, 0777, true);
    }
    $fileUrlNew = $newDir . 'test.xls';
    file_put_contents($fileUrlNew, file_get_contents($filePath));
    return $fileUrlNew;
}
