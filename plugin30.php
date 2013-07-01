<?php // 插件30：引用记录

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo "<a href='" . $_SERVER['PHP_SELF'] .
   "'>Click here to create a Referer</a><br /><ul>";
   
DOPHP_RefererLog("refer.log", "add");
$result = DOPHP_RefererLog("refer.log", "get");

for ($j = 0 ; $j < sizeof($result) ; ++$j)
   echo "<li>$result[$j]</li>";

// Uncomment below to delete the log file afterwards
// DOPHP_RefererLog("refererlog", "delete");

function DOPHP_RefererLog($filename, $action)
{
/*
插件说明：
插件30需要输入两个参数，一个用来保存当前页面数据的文件，另一个是对这个文件的具体操作，详细信息如下：
$filename 用来保存引用页面数据的文件名和路径
$action 对计数值采取的动作：
        reset 表示复位全部计数器；
        add把当前访问添加到计数值；
        get表示读取点击数据；
        delete表示删除计数值文件。
*/
   
   $data = getenv("HTTP_REFERER") . "\n";
   if ($data == "\n") $data = " No Referrer\n";

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
            $file = fread($fp, filesize($filename) -1);
         flock($fp, LOCK_UN);
         fclose($fp);
         $temp = array_unique(explode("\n", $file));
         sort($temp);
         return $temp;

      case "delete":
         unlink($filename);
         return;
   }
}

?>
