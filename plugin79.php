<?php // 插件79：搜索Google图书

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$search = "PHP";

echo "<font face='Arial' size='2'>Google Books results " .
     "for: <b>$search</b>:<br /><br />";

$result = DOPHP_SearchGoogleBooks($search, 1, 20, 'none');

if (!$result[0]) echo "No books found for $search.";
else
{
   foreach($result[1] as $book)
   {
      echo "<img src='$book[5]' align='left' border='1'>";
      echo "<a href='$book[6]'>$book[0]</a> ($book[2], " .
           "$book[3])<br />$book[4]";
      if ($book[7]) echo " (<a href='$book[7]'>preview</a>)";
      echo "<br clear='left'/><br />";
   }
}

function DOPHP_SearchGoogleBooks($search, $start, $count, $type)
{
/*
 * 搜索google图书
 * 插件说明：
 * 插件接受一个搜索串，返回在Google图书数据库中找到的图书。
 * 若操作成功，则返回一个两元素的数组，其中第一个元素表示返回的图书的数量，第二个元素是一个数组，保存这些图书的详细信息。
 * 若操作失败，则返回单个元素的数组，元素的值为FALSE。
 * 本插件需要以下参数：
 * $search 一个标准的搜索查询
 * $start 返回的第一个结果
 * $count 返回结果的最大个数
 * $type 返回结果的类型，如果它的值为none,则表示返回全部图书，
 * 如果它的值为partial,表示只返回书的部分预览内容。
 * 如果它的值为full，则只返回包含完整预览内容在内的全部图书。
 */

   $results = array();
   $url     = 'http://books.google.com/books/feeds/volumes?' .
              'q=' . rawurlencode($search) . '&start-index=' .
              "$start&max-results=$count&min-viewability=" .
              "$type";
   $xml     = @file_get_contents($url);
   if (!strlen($xml)) return array(FALSE);

   $xml  = str_replace('dc:', 'dc', $xml);
   $sxml = simplexml_load_string($xml);

   foreach($sxml->entry as $item)
   {
      $title   = $item->title;
      $author  = $item->dccreator;
      $pub     = $item->dcpublisher;
      $date    = $item->dcdate;
      $desc    = $item->dcdescription;
      $thumb   = $item->link[0]['href'];
      $info    = $item->link[1]['href'];
      $preview = $item->link[2]['href'];

      if (!strlen($pub))
         $pub = $author;
      if ($preview ==
         'http://www.google.com/books/feeds/users/me/volumes')
         $preview = FALSE;
      if (!strlen($desc))
         $desc = '(No description)';
      if (!strstr($thumb, '&sig='))
         $thumb = 'http://books.google.com/googlebooks/' .
            'images/no_cover_thumb.gif';

      $results[] = array($title, $author, $pub, $date, $desc,
         $thumb, $info, $preview);
   }

   return array(count($results), $results);
}

?>
