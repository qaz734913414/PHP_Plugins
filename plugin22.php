<?php // 插件22：从URL地址读取链接信息

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$result = DOPHP_GetLinksFromURL("http://shuimu.js.cn");

echo "<ul>";
for ($j = 0 ; $j < count($result) ; ++$j)
   echo "<li>$result[$j]</li>";

function DOPHP_GetLinksFromURL($page)
{
/*
插件说明：
本插件接受一个web页面的URL地址，对他进行解析，只寻找"<a href "超链接标签，以数组的形式返回所有找到的超链接地址。他需要一个参数：
$page: 一个web页面的URL地址，包括前导符“http://”和域名。
*/

   $contents = @file_get_contents($page);
   if (!$contents) return NULL;
   
   $urls    = array();
   $dom     = new domdocument();
   @$dom    ->loadhtml($contents);
   $xpath   = new domxpath($dom);
   $hrefs   = $xpath->evaluate("/html/body//a");

   for ($j = 0 ; $j < $hrefs->length ; $j++)
      $urls[$j] = DOPHP_RelToAbsURL($page,
         $hrefs->item($j)->getAttribute('href'));

   return $urls;
}

function DOPHP_RelToAbsURL($page, $url)
{

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
