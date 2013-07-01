<?php // 插件76：Yahoo!搜索

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$search  = "yahoo search api";
$results = DOPHP_SearchYahoo($search, 1, 10);
echo "<font face='Arial' size='2'>Searching Yahoo! for: " .
     "<b>$search</b>:<br /><br />";

if (!$results[0]) echo "No matching results found for $search.";
else
   foreach($results[1] as $result)
      echo "<a href='$result[3]'>$result[0]<a/><br />".
           "$result[1]<br />" .
           "<font color='green'>$result[2]</font><br /><br />";

function DOPHP_SearchYahoo($search, $start, $count)
{
/*
 * Yahoo!搜索
 * 插件说明：
 * 插件接受一个搜索串，返货Yahoo!搜索引擎的搜索结果。
 * 若搜索成功，则返回一个两元素数组，第一个元素表示返回结果的个数，第二个元素是一个数组，保存搜索结果，
 * 每个元素都是一个子数组，它具有以下值：
 *    标题
 *    摘要
 *    需要显示的URL地址
 *    用于单击的URL地址
 * 搜索失败，返回一个元素的数组，元素的值为FALSE.
 * 本插件需要以下参数：
 * $search 搜索串
 * $start 返回的第一个结果
 * $count 返回结果的最大个数
 */

   $search = rawurlencode($search);
   $id     = 'YourAPIKeyMustGoInThisStringOrItMayFail';
   $url    = 'http://boss.yahooapis.com/ysearch/web/v1/' .
             "$search?appid=$id&format=xml&start=$start" .
             "&count=$count";

   $xml  = @file_get_contents($url);
   if (!$xml) return array(FALSE);

   $xml  = str_replace('<![CDATA[',        '', $xml);
   $xml  = str_replace(']]>',              '', $xml);
   $xml  = str_replace('&', '[ampersand]', $xml);
   $xml  = str_replace('&',           '&', $xml);
   $xml  = str_replace('[ampersand]', '&', $xml);
   $xml  = str_replace('<b>',     '<b>', $xml);
   $xml  = str_replace('</b>',   '</b>', $xml);
   $xml  = str_replace('<wbr>', '<wbr>', $xml);
   $sxml = simplexml_load_string($xml);
   $data = array();

   foreach($sxml->resultset_web->result as $result)
   {
      $t = html_entity_decode($result->title);
      $a = html_entity_decode($result->abstract);
      $d = html_entity_decode($result->dispurl);
      $c = $result->clickurl;

      if (strlen($a)) $data[] = array($t, $a, $d, $c);
   }

   return array(count($data), $data);
}

?>
