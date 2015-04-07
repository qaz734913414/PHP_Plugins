<?php // 插件78：获取Yahoo!新闻

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$search = "climate change";

echo '<html><head><meta http-equiv="Content-Type" ' .
     'content="text/html; charset=utf-8" /></head><body>';
echo '<font face="Verdana" size="2">';
echo "<font face='Arial' size='2'>Recent news results " .
     "for: <b>$search</b>:<br /><br />";

$results = DOPHP_GetYahooNews($search);

if (!$results[0]) echo "No news found for $search.";
else
   foreach($results[1] as $result)
      echo "<a href='$result[4]'>$result[0]</a> ($result[1], " .
           "$result[2])<br />$result[3]<br /><br />";

function DOPHP_GetYahooNews($search)
{
/*
 * 获取Yahoo!新闻
 * 插件说明：
 * 插件接受一个搜索串，返回http://news.yahoo.com网页上与此搜索串有关的新闻。
 * 若操作成功，则返回一个两元素的数组，其中第一个元素表示返回的新闻的个数，
 * 第二个元素是一个子数组，它包含以下信息：
 *     标题
 *     发布网站
 *     日期
 *     新闻摘要和说明
 *     原新闻的URL地址
 * 若操作失败，若返回一个元素的数组，元素的值为FALSE。
 * 本插件需要以下参数：
 * $search 一个标准的搜索串
 */

   $reports = array();
   $url     = 'http://news.search.yahoo.com/news/rss?' .
              'ei=UTF-8&fl=0&x=wrt&p=' . rawurlencode($search);
   $xml     = @file_get_contents($url);
   if (!strlen($xml)) return array(FALSE);

   $xml  = str_replace('<![CDATA[',        '', $xml);
   $xml  = str_replace(']]>',              '', $xml);
   $xml  = str_replace('&', '[ampersand]', $xml);
   $xml  = str_replace('&',           '&', $xml);
   $xml  = str_replace('[ampersand]', '&', $xml);
   $xml  = str_replace('<b>',     '<b>', $xml);
   $xml  = str_replace('</b>',   '</b>', $xml);
   $xml  = str_replace('<wbr>', '<wbr>', $xml);
   $sxml = simplexml_load_string($xml);

   foreach($sxml->channel->item as $item)
   {
      $flag  = FALSE;
      $url   = $item->link;
      $date  = date('M jS, g:ia', strtotime($item->pubDate));
      $title = $item->title;
      $temp  = explode(' (', $title);
      $title = $temp[0];
      $site  = str_replace(')', '', $temp[1]);
      $desc  = $item->description;

      for ($j = 0 ; $j < count($reports) ; ++$j)
      {
         similar_text(strtolower($reports[$j][0]),
            strtolower($title), $percent);

         if ($percent > 70)
         {
            $flag = TRUE;
            break;
         }
      }

      if (!$flag && strlen($desc))
         $reports[] = array($title, $site, $date, $desc, $url);
   }

   return array(count($reports), $reports);
}

?>
