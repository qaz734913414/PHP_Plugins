<?php // 插件9：去掉重音符号

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text = "带有重音符号的文本";

echo "$text<br /><br />";
echo DOPHP_RemoveAccents($text);

function DOPHP_RemoveAccents($text)
{
/*
插件说明：
插件9输入包含重音符的字符串，返回转换后的字符串。他要求以下参数：
$text 字符串变量，包含需要转换的文本。
*/

   $from = array("重音符号1","重音符号2","重音符号3");

   $to =   array("对应非重音符号1","对应非重音符号2","对应非重音符号3");
                 
   return str_replace($from, $to, $text);
}

?>