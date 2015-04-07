<?php // 插件7：自动截断

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$text  = "It was the best of times, it was the worst of times, it was the age of wisdom, it was the age of foolishness, it was the epoch of belief, it was the epoch of incredulity, it was the season of Light, it was the season of Darkness, it was the spring of hope, it was the winter of despair, we had everything before us, we had nothing before us, we were all going direct to heaven.";

echo "$text<br /><br />";
echo DOPHP_TextTruncate($text, 28, ".....") . "<br />";
echo DOPHP_TextTruncate($text, 50, "———")       . "<br />";
echo DOPHP_TextTruncate($text, 90, "。。。")      . "<br />";

function DOPHP_textTruncate($text, $max, $symbol)
{
/*
插件说明：
插件7有三个参数。第一个参数表示需要处理的文本，第二个参数表示在新字符串里允许的最大个数，第三个参数是一个符号或字符串，它添加在截断文本后面，说明已经执行了阶段操作。它的三个参数分别是：
$text 字符串变量，包含需要处理的文本
$max 数值变量，表示最大的字符个数
$symbol 字符串变量，表示添加在新文本的后面
*/
   $temp = substr($text, 0, $max);
   $last = strrpos($temp, " ");
   $temp = substr($temp, 0, $last);
   $temp = preg_replace("/([^\w])$/", "", $temp);
   return "$temp$symbol";
}

?>