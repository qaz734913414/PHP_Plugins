<?php // 插件41：检查链接

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$url   = "http://www.baidu.com";
$links = array("http://www.hao123.com",
               "http://hao.360.cn",
               "http://www.114la.com/index.html");

echo "<b>检查下列网址是否链接到 '$url':</b><br /><br />";
for ($j = 0 ; $j < count($links) ; ++$j)
   echo $links[$j] . "<br />";

$result = DOPHP_LookupLinks($url, $links);
if ($result[0]) echo "<br /><b>检测到了以下外链：</b>";
else
{
   echo "<br /><b>以下外链检测失败:</b><br /><br />";
   
   for ($j = 0 ; $j < count($result[1]) ; ++$j)
      echo $result[1][$j] . "<br />";
}

function DOPHP_LookupLinks($url, $links)
{
/*
插件说明：
插件41接受一个需要检查链接的网页URL地址和一组需要且必须出现在此网页上的链接地址。如果这些链接都出现在此网页上，则返回一个值为TRUE的数组，否则返回一个两元素的数组。其中第一个元素的值为FALSE,第二个元素保存了所有没有出现在此网页上的链接地址。这个插件具体参数如下：
$url 字符串，表示需要检查的网页的URL地址。
$links 数组，出现在$url页面上的链接地址.
*/
   $results = DOPHP_GetLinksFromURL($url);
   $missing = array();
   $failed  = 0;
   
   foreach($links as $link)
      if (!in_array($link, $results))
         $missing[$failed++] = $link;
         
   if ($failed == 0) return array(TRUE);
   else return array(FALSE, $missing);
}

function DOPHP_GetLinksFromURL($page)
{

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
