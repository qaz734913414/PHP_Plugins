<?php // 插件48：把HTML文件转换为RSS文件

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$url         = "http://shuimu.js.cn/";
$html        = file_get_contents($url);
$title       = "RSS version of '$url'";
$description = "The website '$url' converted to an RSS feed";
$webmaster   = "admin@4u4v.net";
$copyright   = "Translator Copyright 2013 shuimu.js.cn";

header('Content-Type: text/xml');
echo DOPHP_HTMLToRSS($html, $title, $description, $url,
   $webmaster, $copyright);

function DOPHP_HTMLToRSS($html, $title, $description, $url,
   $webmaster, $copyright)
{
/*
插件说明：
本插件接受一个HTML文档或其他相关参数，返回一个格式正确的RSS文件。他需要以下参数：
$html 需要转换的HTML文档
$title 作为RSS文件的标题
$description RSS文件说明
$url 该RSS文件链接的URL
$wenmaster 网站管理员的Email地址
$copyright 版权信息
*/
   $date  = date("D, d M Y H:i:s e");
   $html  = str_replace('&', '&',         $html);
   $html  = str_replace('&',     '!!**1**!!', $html);
   $dom   = new domdocument();
   @$dom  ->loadhtml($html);
   $xpath = new domxpath($dom);
   $hrefs = $xpath->evaluate("/html/body//a");
   $links = array();
   $to    = array();
   $count = 0;

   for ($j = 0 ; $j < $hrefs->length ; ++$j)
      $links[] = $hrefs->item($j)->getAttribute('href');

   $links = array_unique($links);
   sort($links);

   foreach ($links as $link)
   {
      if ($link != "")
      {
         $temp = str_replace('!!**1**!!', '&', $link);
         $to[$count] = urlencode(DOPHP_RelToAbsURL($url, $temp));
         $html = str_replace("href=\"$link\"",
            "href=\"!!$count!!\"", $html);
         $html = str_replace("href='$link'",
            "href='!!$count!!'",   $html);
         $html = str_replace("href=$link",
            "href=!!$count!!",     $html);
         ++$count;
      }
   }

   for ($j = 0 ; $j < $count ; ++$j)
      $html = str_replace("!!$j!!", $to[$j],
         $html);

   $html = str_replace('http%3A%2F%2F', 'http://', $html);
   $html = str_replace('!!**1**!!', '&', $html);
   $html = preg_replace('/[\s]+/', ' ', $html);
   $html = preg_replace('/<script[^>]*>.*?<\/script>/i', '',
      $html);
   $html = preg_replace('/<style[^>]*>.*?<\/style>/i', '',
      $html);
   $ok   = '<a><i><b><u><s><h><img><div><span><table><tr>';
   $ok  .= '<th><tr><td><br><p><ul><ol><li>';
   $html = strip_tags($html, $ok);
   $html = preg_replace('/<h[1-7][^>]*?>/i', '<h>',
      $html);
   $html = htmlentities($html);
   $html = preg_replace("/<h>/si",
      "</description></item>\n<item><title>", $html);
   $html = preg_replace("/<\/h[1-7]>/si",
      "</title><guid>$url</guid><description>", $html);
	
	return <<<_END
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"><channel>
<generator>ShuiMu</generator>
<title>$title</title><link>$url</link>
<description>$description</description>
<language>en</language>
<webMaster>$webmaster</webMaster>
<copyright>$copyright</copyright>
<pubDate>$date</pubDate>
<lastBuildDate>$date</lastBuildDate>
<item><title>$title</title>
<guid>$url</guid>
<description>$html</description></item></channel></rss>
_END;
}
?>

<?php
// The below function is repeated here to ensure that it's
// available to the main function which relies on it

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
