<?php // 插件46：简单的web代理服务器

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$url = $_GET['u'];

$result = DOPHP_SimpleWebProxy(urldecode($_GET['u']), "webproxy.php");

switch(strtolower(substr($url, -4)))
{
   case ".jpg":
      header("Content-type: image/jpeg");   die($result);
   case ".gif":
      header("Content-type: image/gif");    die($result);
   case ".png":
      header("Content-type: image/png");    die($result);
   case ".ico":
      header("Content-type: image/x-icon"); die($result);
   case ".css":
      header("Content-type: text/css");     die($result);
   case ".xml":
      header("Content-type: text/xml");     die($result);
   case ".htm": case "html": case ".php":
      header("Content-type: text/html");    die($result);
   default:
      if (strtolower(substr($url, -3)) == ".js")
         header("Content-type: application/x-javascript");
      die($result);
}

function DOPHP_SimpleWebProxy($url, $redirect)
{
/*
插件说明：
插件接受一个URL地址，把它全部链接都改为通过代理访问，返回修改后的URL地址，他需要接受以下参数：
$url 需要转换的URL
$redirect 提供web代理的PHP程序的文件名
*/
   $contents = @file_get_contents($url);
   if (!$contents) return NULL;
   
   switch(strtolower(substr($url, -4)))
   {
      case ".jpg": case ".gif": case ".png": case ".ico":
      case ".css": case ".js": case ".xml":
         return $contents;
   }

   $contents = str_replace('&', '&',         $contents);
   $contents = str_replace('&', '!!**1**!!', $contents);
   
   $dom      = new domdocument();
   @$dom     ->loadhtml($contents);
   $xpath    = new domxpath($dom);
   $hrefs    = $xpath->evaluate("/html/body//a");
   $sources  = $xpath->evaluate("/html/body//img");
   $iframes  = $xpath->evaluate("/html/body//iframe");
   $scripts  = $xpath->evaluate("/html//script");
   $css      = $xpath->evaluate("/html/head/link");
   $links    = array();

   for ($j = 0 ; $j < $hrefs->length ; ++$j)
      $links[] = $hrefs->item($j)->getAttribute('href');
    
   for ($j = 0 ; $j < $sources->length ; ++$j)
      $links[] = $sources->item($j)->getAttribute('src');

   for ($j = 0 ; $j < $iframes->length ; ++$j)
      $links[] = $iframes->item($j)->getAttribute('src');

   for ($j = 0 ; $j < $scripts->length ; ++$j)
      $links[] = $scripts->item($j)->getAttribute('src');

   for ($j = 0 ; $j < $css->length ; ++$j)
      $links[] = $css->item($j)->getAttribute('href');

   $links = array_unique($links);
   $to    = array();
   $count = 0;
   sort($links);
   
   foreach ($links as $link)
   {
      if ($link != "")
      {
         $temp = str_replace('!!**1**!!', '&', $link);

         $to[$count] = "/$redirect?u=" .
           urlencode(DOPHP_RelToAbsURL($url, $temp));
         $contents = str_replace("href=\"$link\"",
            "href=\"!!$count!!\"", $contents);
         $contents = str_replace("href='$link'",
            "href='!!$count!!'",   $contents);
         $contents = str_replace("href=$link",
            "href=!!$count!!",     $contents);
         $contents = str_replace("src=\"$link\"",
            "src=\"!!$count!!\"",  $contents);
         $contents = str_replace("src='$link'",
            "src='!!$count!!'",    $contents);
         $contents = str_replace("src=$link",
            "src=!!$count!!",      $contents);
         ++$count;
      }
   }

   for ($j = 0 ; $j < $count ; ++$j)
      $contents = str_replace("!!$j!!", $to[$j],
         $contents);

   return str_replace('!!**1**!!', '&', $contents);
}

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
