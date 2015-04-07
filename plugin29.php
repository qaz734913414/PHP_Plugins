<?php // 插件29：点击计数器

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

DOPHP_HitCounter("testcounter", "reset");

for ($j = 0 ; $j < 5 ; ++$j)
   DOPHP_HitCounter("testcounter", "add");

$result = DOPHP_HitCounter("testcounter", "get");
echo "Raw: $result[0] / Unique: $result[1]<br />";

DOPHP_HitCounter("testcounter", "delete");

function DOPHP_HitCounter($filename, $action)
{
/*
本插件接受一个保存统计信息的文件名和相关的操作信息，具体是：
$filename 保存计数值的文件名或路径
$action 对计数值采取的操作：
reset表示复位全部计数器；
add把当前访问添加到计数值；
get表示读取点击数据；
delete表示删除计数值文件
*/
   $data = getenv("REMOTE_ADDR") .
           getenv("HTTP_USER_AGENT") . "\n";
   
   switch ($action)
   {
      case "reset":
         $fp = fopen($filename, "w");
         if (flock($fp, LOCK_EX))
            ;
         flock($fp, LOCK_UN);
         fclose($fp);
         return;

      case "add":
         $fp = fopen($filename, "a+");
         if (flock($fp, LOCK_EX))
            fwrite($fp, $data);
         flock($fp, LOCK_UN);
         fclose($fp);
         return;

      case "get":
         $fp = fopen($filename, "r");
         if (flock($fp, LOCK_EX))
            $file = fread($fp, filesize($filename) - 1);
         flock($fp, LOCK_UN);
         fclose($fp);
         $lines  = explode("\n", $file);
         $raw    = count($lines);
         $unique = count(array_unique($lines));
         return array($raw, $unique);

      case "delete":
         unlink($filename);
         return;
   }
}

?>
