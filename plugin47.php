<?php // 插件47：网页更新

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$page     = "http://shuimu.js.cn";
$datafile = "urldata.txt";
$result   = DOPHP_PageUpdated($page, $datafile);
echo      "<pre>(1st call) The URL '$page' is ";

if     ($result == -1) echo "New";
elseif ($result == 1)  echo "Changed";
elseif ($result == 0)  echo "Unchanged";
else                   echo "Inaccessible";

$result   = DOPHP_PageUpdated($page, $datafile);
echo      "<br />(2nd call) The URL '$page' is ";

if     ($result == -1) echo "New";
elseif ($result == 1)  echo "Changed";
elseif ($result == 0)  echo "Unchanged";
else                   echo "Inaccessible";

function DOPHP_PageUpdated($page, $datafile)
{
/*
插件说明：
插件接受一个web页面的URL地址，告诉我们这个网页是否发生变化。如果已经发生变化，返回1，没有发生变化，返回0，如果他是一个新网页，数据文件里还没有它的记录，则返回-1，如果这个网页无法访问，则返回-2，它需要以下参数：
$page 需要检查网页的URL地址
$datafile 数据文件名: urldata.tx
*/

   $contents = @file_get_contents($page);
   if (!$contents) return FALSE;

   $checksum = md5($contents);

   if (file_exists($datafile))
   {
      $rawfile  = file_get_contents($datafile);
      $data     = explode("\n", rtrim($rawfile));
      $left     = array_map("DOPHP_PU_F1", $data);
      $right    = array_map("DOPHP_PU_F2", $data);
      $exists   = -1;

      for ($j = 0 ; $j < count($left) ; ++$j)
      {
         if ($left[$j] == $page)
         {
            $exists = $j;
            if ($right[$j] == $checksum) return 0;
         }
      }

      if ($exists > -1)
      {
         $rawfile = str_replace($right[$exists],
            $checksum, $rawfile);
         file_put_contents($datafile, $rawfile);
         return 1;
      }
   }
   else $rawfile = "";

   file_put_contents($datafile, $rawfile .
      "$page!1!$checksum\n");

   return -1;
}


function DOPHP_PU_F1($s)
{
   list($a, $b) = explode("!1!", $s);
   return $a;
}

function DOPHP_PU_F2($s)
{
   list($a, $b) = explode("!1!", $s);
   return $b;
}

?>
