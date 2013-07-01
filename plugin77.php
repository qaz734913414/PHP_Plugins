<?php // 插件77：获取Yahoo!股票新闻

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$stock   = "AAPL";
$results = DOPHP_GetYahooStockNews($stock);
echo "<font face='Arial' size='2'>Fetching recent news " .
     "stories for: <b>$stock</b>:<br /><br />";

if (!$results[0]) echo "No stories found for $stock.";
else
{
   echo "<a href='http://finance.yahoo.com/q?s=$stock'>".
        "<img src='" . $results[1][0] . "' border='1' />" .
        '</a><br /><br />';

   foreach($results[2] as $result)
      echo "<a href='$result[4]'>$result[0]</a> " .
           "($result[1], $result[2])<br />$result[3]" .
           '<br /><br />';
}

function DOPHP_GetYahooStockNews($stock)
{
/*
 * 获取Yahoo!股票新闻
 * 插件说明：
 * 插件接受一个股票代码，如AAPL或MSFT，返回该股票的相关新闻和股份信息。
 * 若操作成功，则返回一个三元素数组。
 * 第一个元素是新闻故事的个数。
 * 第二个元素是一个子数组，保存两个URL地址，
 * 第一个是该股票当天的股价小图，第二个是它的大图。
 * 而第三个元素是一个子数组，包含一下详细信息：
 *     标题
 *     发布网站
 *     日期
 *     新闻摘要和详细报道
 *     新闻内容的源URL地址
 * 若操作失败，则返回一个值为FALSE的数组。
 * 本插件需要以下参数：
 * $stock 一个有效地股票代码，如YHOO或JPM.
 */

   $stock = strtoupper($stock);
   $url   = 'http://finance.yahoo.com';
   $check = @file_get_contents("$url/q?s=$stock");

   if (stristr($check, 'Invalid Ticker Symbol') || $check == '')
      return array(FALSE);

   $reports = array();
   $xml     = file_get_contents("$url/rss/headline?s=$stock");
   $xml     = preg_replace('/<\/?summary>/', '', $xml);
   $xml     = preg_replace('/<\/?image>/',   '', $xml);
   $xml     = preg_replace('/<\/?guid>/',    '', $xml);
   $xml     = preg_replace('/<\/?p?link>/',  '', $xml);
   $xml     = str_replace('<![CDATA[',          '', $xml);
   $xml     = str_replace(']]>',                '', $xml);
   $xml     = str_replace('&',      '[ampersand]', $xml);
   $xml     = str_replace('&',                '&', $xml);
   $xml     = str_replace('[ampersand]',      '&', $xml);
   $xml     = str_replace('<b>',          '<b>', $xml);
   $xml     = str_replace('</b>',        '</b>', $xml);
   $xml     = str_replace('<wbr>',      '<wbr>', $xml);
   $sxml    = simplexml_load_string($xml);

   foreach($sxml->channel->item as $item)
   {
      $flag  = FALSE;
      $url   = $item->link;
      $title = $item->title;
      $temp  = explode(' (', $title);
      $title = $temp[0];
      $site  = str_replace(')', '', $temp[1]);
      $site  = str_replace('at ', '', $site);
      $desc  = $item->description;
      $date  = date('M jS, g:ia',
         strtotime(substr($item->pubDate, 0, 25)));

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

      if (!$flag && !strstr($title, '[$]') && strlen($desc))
         $reports[] = array($title, $site, $date, $desc, $url);
   }

   $url1 = "http://ichart.finance.yahoo.com/t?s=$stock";
   $url2 = "http://ichart.finance.yahoo.com/b?s=$stock";
   return array(count($reports), array($url1, $url2), $reports);
}

?>
