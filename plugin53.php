<?php // 插件53：获取留言薄消息

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$result = DOPHP_GetGuestBook('guestbook.txt', 'f');

if (!$result[0]) echo "No posts";
else
{
   for ($j = 0 ; $j < $result[0] ; ++$j)
   {
      echo "<b>Post " . ($j + 1) . "</b>:<br /><br />";
      
      for ($k = 0 ; $k < 4 ; ++$k)
         echo "&nbsp; " . $result[1][$j][$k] . "<br />";
   }
}

function DOPHP_GetGuestBook($datafile, $order)
{
/*
 * 插件说明：
 * 插件用于接受一个保存留言薄信息的数据文件名，返回这个文件全部内容。如果读取成功，则返回一个两元素的数组，其中第一个元素表示帖子数量，第二个元素本身也是
 * 一个数组，它表示全部帖子内容。如果读取失败，则返回一个元素的数组，这个元素的值为FALSE。它需要以下参数：
 * $datafile 字符串变量，表示留言薄文件所在的位置。
 * $order 帖子返回的排列顺序。如果值为“1”则把帖子排列成逆序形式，即最新的帖子排在前面，否则将帖子予以最早到最近的顺序排列。
 */
   
   if (!file_exists($datafile)) return array(0);

   $data  = array();
   $posts = explode("\n",
      rtrim(file_get_contents($datafile)));

   if (strtolower($order) == 'r')
      $posts = array_reverse($posts);

   foreach ($posts as $post)
      $data[] = explode('!1!', $post);

   return array(count($posts), $data);
}

?>
