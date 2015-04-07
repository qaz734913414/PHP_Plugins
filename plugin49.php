<?php // 插件49：把RSS文件转换为HTML文件

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$url = "http://shuimu.js.cn/feed";
$rss = file_get_contents($url);
echo   DOPHP_RSSToHTML($rss);

function DOPHP_RSSToHTML($rss)
{
/*
插件说明：
插件接受一个字符串，它表示需要转换的RSS源，返回转换后的HTML文档。
参数：
$rss 需要转换的RSS源内容
*/

   $xml    = simplexml_load_string($rss);
   $title  = @$xml->channel->title;
   $link   = @$xml->channel->link;
   $desc   = @$xml->channel->description;
   $copyr  = @$xml->channel->copyright;
   $ilink  = @$xml->channel->image->link;
   $ititle = @$xml->channel->image->title;
   $iurl   = @$xml->channel->image->url;

   $out = "<html><head><style> img {border: 1px solid " .
          "#444444}</style>\n<body>";

   if ($ilink != "")
      $out    .= "<a href='$ilink'><img src='$iurl' title=" .
                 "'$ititle' alt='$ititle' border='0' style=" .
                 "'border: 0px' align='left' /></a>\n";
   
   $out .= "<h1>$title</h1>\n<h2>$desc</h2>\n";
   
   foreach($xml->channel->item as $item)
   {
      $tlink  = @$item->link;
      $tdate  = @$item->pubDate;
      $ttitle = @$item->title;
      $tdesc  = @$item->description;
      
      $out   .= "<h3><a href='$tlink' title='$tdate'>" .
                "$ttitle</a></h3>\n<p>$tdesc</p>\n";
   }

   return "$out<a href='$link'>$copyr</a></body></html>";
}

?>
