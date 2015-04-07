<?php // 插件50：把HTML转换为适用于移动浏览器的HTML页面

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$url    = "http://yahoo.com";
$html   = file_get_contents($url);
$style  = "no";
$images = "yes";

echo    DOPHP_HTMLToMobile($html, $url, $style, $images);

function DOPHP_HTMLToMobile($html, $url, $style, $images)
{
/*
插件说明：
插件接受一个包含需要转换的HTML页面的字符串和其他参数，返回一个删除需多格式控制元素后、使用正常格式的HTML文档。
$html 需要转换的HTML页面。
$url 需要转换的页面的URL地址
$style 如果值为yes，则保留样式和javascript元素，否则删除。
$images 如果值为yes，保留图像，否则删除。
*/

   $dom   = new domdocument();
   @$dom  ->loadhtml($html);
   $xpath = new domxpath($dom);
   $hrefs = $xpath->evaluate("/html/body//a");
   $links = array();
   $to    = array();
   $count = 0;
   $html  = str_replace('&', '&',         $html);
   $html  = str_replace('&',     '!!**1**!!', $html);

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
      $html = str_replace("!!$j!!", $to[$j], $html);

   $html = str_replace('http%3A%2F%2F', 'http://', $html);
   $html = str_replace('!!**1**!!', '&', $html);

   if (strtolower($style) != "yes")
   {
      $html = preg_replace('/[\s]+/', ' ', $html);
      $html = preg_replace('/<script[^>]*>.*?<\/script>/i', '',
         $html);
      $html = preg_replace('/<style[^>]*>.*?<\/style>/i', '',
         $html);
   }

   $allowed = "<a><p><h><i><b><u><s>";
   if (strtolower($images) == "yes") $allowed .= "<img>";
   return strip_tags($html, $allowed);
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
