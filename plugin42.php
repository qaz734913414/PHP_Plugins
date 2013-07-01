<?php // 插件42：从URL地址读取标题

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$page   = "http://shuimu.js.cn";
$result = DOPHP_GetTitleFromURL($page);

if (!$result) echo "网址为：'$page'，该网站无法访问！";
else echo "网址为：'$page'，该网站的标题是:<br /><br /><i>$result</i>";

function DOPHP_GetTitleFromURL($page)
{
/*
插件说明：
插件接受一个Web页面的URL地址，读取并返回它的标题。他需要以下参数：
$page 字符串，包含需要检查的web页面的URL地址。
*/

   $contents = @file_get_contents($page);
   if (!$contents) return FALSE;
   
   preg_match("/<title>(.*)<\/title>/i", $contents, $matches);
   return $matches[1];
}

?>
