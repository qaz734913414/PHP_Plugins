<?php // 插件21：把URL相对地址转换为绝对地址

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo "<font face='Courier New' size='2'><pre>";
$page = "http://site.com/news/current/science/index.html";
$link = "../../prev/tech/roundup.html";
echo "Page: $page<br />Link: $link\n";
echo "Abs:  " . DOPHP_RelToAbsURL($page, $link);

$link = "/sport/index.htm";
echo "\n\nPage: $page<br />Link: $link\n";
echo "Abs:  " . DOPHP_RelToAbsURL($page, $link);

$page = "http://site.com/news/current/science/";
$link = "/sport/index.htm";
echo "\n\nPage: $page<br />Link: $link\n";
echo "Abs:  " . DOPHP_RelToAbsURL($page, $link);

$link = "../../prev/tech/roundup.html";
echo "\n\nPage: $page<br />Link: $link\n";
echo "Abs:  " . DOPHP_RelToAbsURL($page, $link);

function DOPHP_RelToAbsURL($page, $url)
{
/*
插件说明：
本插件接受一个web也没的URL地址和该页面的一个链接，然后返回这个链接的绝对地址。
通过这个地址可以直接访问这个链接页面而无需通过引用页面。简而言之，他返回一个URL绝对地址。本插件需要以下参数：
$page 一个web页面的URL地址，包括”http://"前导符的域名。
$url $page页面上的一个链接。
*/
   if (substr($page, 0, 7) != "http://") return $url;
   
   $parse = parse_url($page);
   $root  = $parse['scheme'] . "://" . $parse['host'];
   $p     = strrpos(substr($page, 7), '/');
   
   if ($p) $base = substr($page, 0, $p + 8);
   else $base = "$page/";
   
   if (substr($url, 0, 1) == '/')           $url = $root . $url;
   elseif (substr($url, 0, 7) != "http://") $url = $base . $url;
   
   return $url;
}
?>
