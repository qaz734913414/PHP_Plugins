<?php // 插件5：单词选择器

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

function DOPHP_WordSelector($text, $matches, $replace)
{
/*
插件说明：
插件5需要三个参数，一个参数表示需要处理的文本，一个数组代表需要突出显示的单词，还有一个参数代表突出显示的类型。它们是：
$text 字符串参数，表示需要处理的文本
$matches 数组，表示需要突出显示的单词
$replace 字符串参数，代表对相应单词采取的动作。如果它的值是u,b或i，则相应使用下划线、粗体或斜线突出显示匹配的单词，否则用replace参数里的内容替换相应的单词。
*/
   foreach($matches as $match)
   {
      switch($replace)
      {
         case "u":
         case "b":
         case "i":
            $text = preg_replace("/([^\w]+)($match)([^\w]+)/i",
               "$1<$replace>$2</$replace>$3", $text);
            break;

         default:
            $text = preg_replace("/([^\w]+)$match([^\w]+)/i",
               "$1$replace$2", $text);
            break;
      }
   }

   return $text;
}

$words = array("the", "this", "that", "is", "these"); //匹配的关键字(数组)
$text  = "We hold These truths to be self-evident, that all men are created equal, that they are endowed by their Creator with certain unalienable Rights, that among these are Life, Liberty and the pursuit of Happiness.";

echo DOPHP_WordSelector($text, $words, "u") . "<br /><br />";
echo DOPHP_WordSelector($text, $words, "****");

?>