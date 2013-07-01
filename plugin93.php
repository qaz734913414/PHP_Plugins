<?php // 插件93: 根据ISBN获取图书

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$isbn   = '007149216X';
$result = DOPHP_GetBookFromISBN($isbn);
if (!$result) echo "Could not find title for ISBN '$isbn'.";
else echo "<img src='$result[1]' align='left'><b>$result[0]";

function DOPHP_GetBookFromISBN($isbn)
{
/*
* 根据ISBN获取图书
* 插件说明：
* 插件根据提供的10位ISBN书号，在Amazon网站上查找该图书的详细信息。
* 如果找到结果，则返回一个两元素的数组，其中第一个元素是书的标题，而第二个元素是该书封面缩写图的URL地址。
* 它需要以下参数：
* $ISBN 10位ISBN书号
*/

   $find = '<meta name="description" content="Amazon:';
   $url  = "http://www.amazon.com/gp/aw/d.html?a=$isbn";
   $img  = 'http://ecx.images-amazon.com/images/I';

   $page = @file_get_contents($url);
   if (!strlen($page)) return array(FALSE);

   $ptr1 = strpos($page, $find) + strlen($find);
   if (!$ptr1) return array(FALSE);

   $ptr2  = strpos($page, '" />', $ptr1);
   $title = substr($page, $ptr1, $ptr2 - $ptr1);

   $find = $img;
   $ptr1  = strpos($page, $find) + strlen($find);
   $ptr2  = strpos($page, '"', $ptr1);
   $image = substr($page, $ptr1, $ptr2 - $ptr1);

   return array($title, $img . $image);
}

?>
