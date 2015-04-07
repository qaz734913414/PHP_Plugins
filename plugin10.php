<?php // 插件10：文本简化

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text = "http://rover.ebay.com/rover/1/711-53200-19255-0/1?type=3&campid=5336224516&toolid=10001&customid=tiny-hp&ext=unicycle&satitle=unicycle";

echo "Before: <a href=$text>$text</a><br /><br />";
echo "After: <a href=\"$text\">" . DOPHP_ShortenText($text, 60, "/-/-/") . "</a>";

function DOPHP_ShortenText($text, $size, $mark)
{
/*
插件说明：
插件10接受一个字符串变量，它代表一个需要简化的长URL地址（或其他字符串），返回简化后的URL地址，它需要用到以下参数：
$text 字符串变量，包含需要处理的文本
$size 数值变量，表示新字符串的大小
$mark 字符串变量，包含一个字符序列，标志字符串删除部分。
*/

   $len = strlen($text);
   if ($size >= $len) return $text;

   $a = substr($text, 0, $size / 2 -1);
   $b = substr($text, $len - $size / 2 + 1, $size / 2 -1);
   return $a . $mark . $b;
}

?>