<?php // 插件44：建立URL断地址

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$long     = "http://www.4u4v.net/php-through-the-array-list-foreach-each-for-methods.html";
$redirect = "PHP_Plugins/go.php";
$len      = 5;
$file     = "shorturls.txt";
$result   = DOPHP_CreateShortURL($long, $redirect, $len, $file);

echo      "The URL '$long' can now be accessed from: ";
echo      "<a href='/$result'>/$result</a>";

function DOPHP_CreateShortURL($url, $redirect, $len, $file)
{
/*
插件说明：
插件接受一个需要简化的URL地址和其他数据，返回一个URL断地址，他需要以下参数：
$url: 需要简化的URL地址
$redirect：服务器上一个PHP程序的名字，它会把URL短地址重定向到原来的目标地址。
$len：可以出现在URL短地址里面的字符个数，这个数值越大，支持的URL地址越多。例如3个字符可以支持4096个URL地址，
因为，本插件使用十六进制的0~0和a~f共16个字符
$file 用来保存URL短地址的文件名。
*/

   $contents = @file_get_contents($file);
   $lines    = explode("\n", $contents);
   $shorts   = array();
   $longs    = array();

   if (strlen($contents))
      foreach ($lines as $line)
         if (strlen($line))
            list($shorts[], $longs[]) = explode('|', $line);

   if (in_array($url, $longs))
      for ($j = 0 ; $j < count($longs) ; ++$j)
         if ($longs[$j] == $url) return $redirect .
            "?u=" . $shorts[$j];

   do $str = substr(md5(rand(0, 1000000)), 0, $len);
   while (in_array($str, $shorts));
   
   file_put_contents($file, $contents . $str . '|' . $url .
      "\n");
   return $redirect . "?u=$str";
}

?>
