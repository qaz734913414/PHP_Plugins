<?php // 插件24：目录列表

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$directory = "c:\windows\\";
$result    = DOPHP_DirectoryList($directory);
echo         "<b>Listing:</b> $directory<br /><br />";

if ($result[0] == 0) echo "No Directories";
else
{
   echo "<b>Directories:</b> ";
   for ($j=0 ; $j < $result[0] ; ++$j)
      echo $result[2][$j] . ", ";
}

echo "<br /><br />";

if ($result[1] == 0) echo "No files";
else
{
   echo "<b>Files:</b> ";
   for ($j=0 ; $j < $result[1] ; ++$j)
      echo $result[3][$j] . ", ";
}

function DOPHP_DirectoryList($path)
{
/*
插件说明：
本插件接受服务器某个目录的位置，以数组的形式返回这个目录的全部文件。如果操作成功，则返回一个四元素的数组。
其中第一个元素是找到的目录个数；第二个元素是找到的文件个数；第三个元素是一个数组，用于保存找到的目录名；第四个元素也是一个数组，用于保存找到的全部文件名。
如果操作失败则返回一个只有一个元素的数组，元素的值为FALSE。
他需要参数：$path:服务器某个目录的路径。
*/

   $files = array();
   $dirs  = array();
   $fnum  = $dnum = 0;

   if (is_dir($path))
   {
      $dh = opendir($path);

      do
      {
         $item = readdir($dh);

         if ($item !== FALSE && $item != "." && $item != "..")
         {
            if (is_dir("$path/$item")) $dirs[$dnum++] = $item;
            else $files[$fnum++] = $item;
         }
      } while($item !== FALSE);
   
      closedir($dh);
   }

   return array($dnum, $fnum, $dirs, $files);
}

?>
