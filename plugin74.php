<?php // 插件74：读取Flickr流

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$account = 'robinfnixon';
$result  = DOPHP_FetchFlickrStream($account);
$count   = 1;

echo "<b>Flickr account:</b> <i>$account</i> ";

if (!$result[0]) echo 'No photos found.';
else foreach($result[1] as $photo)
   echo "<a href='$photo'>Photo " . $count++ . '</a> ';

function DOPHP_FetchFlickrStream($account)
{
/*读取Flickr流
 * 插件说明：
 * 本插件接受一个Flickr公开的用户名，返回一系列最新图片。
 * 若操作成功，则返回一个两元素的数组，第一个元素返回图片的数量，第二个元素是一个数组，表示每个图片的URL地址。
 * 若操作失败，则返回一个单元素的数组，元素的值为FALSE。
 * 它需要以下参数：
 * $account Flickr用户名，它的格式为：xxxxxx@Nxx（这里的x代表数字）
 * 或者像这样比较有好的用户名,如robinfnixon.
 */

   $url  = 'http://flickr.com/photos';
   $page = @file_get_contents("$url/$account/");
   if (!$page) return array(FALSE);

   $pics = array();
   $rss  = strstr($page, 'rss+xml');
   $rss  = strstr($rss, 'http://');
   $rss  = substr($rss, 0, strpos($rss, '"'));
   $xml  = file_get_contents($rss);
   $sxml = simplexml_load_string($xml);

   foreach($sxml->entry as $item)
   {
      for ($j=0 ; $j < sizeof($item->link) ; ++$j)
      {
         if (strstr($item->link[$j]['type'], 'image'))
         {
            $t=str_replace('_m', '', $item->link[$j]['href']);
            $t=str_replace('_t', '', $t);
            $pics[]=$t;
         }
      }
   }
   
   return array(count($pics), $pics);
}

?>
