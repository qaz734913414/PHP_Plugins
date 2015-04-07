<?php // 插件58：接收tweet消息

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$user   = 'eminem';
$result = DOPHP_GetTweets($user);

echo "Viewing '$user':<br /><ul>";

if (!$result[0]) echo 'Failed';
else
   for ($j = 0 ; $j < $result[0] ; ++$j)
      echo "<li>" . $result[1][$j] . "</li>";

function DOPHP_GetTweets($user)
{
/*
 * 插件说明：
 * 插件从一个公开的Twitter用户中读取最后20条Tweet消息。
 * 接受一个Twitter账户的用户名，如果它是公开的，则返回它最近的Tweet消息。
 * 访问成功，则返回一个两元素的数组，其中第一个元素表示Tweet消息的个数，第二个元素包含一个数组，保存每个Tweet消息。
 * 访问失败，则返回只有一个元素的数组，这个元素的值为FALSE。它需要以下参数：
 * $user Twitter用户名。
 */

   $url  = "http://twitter.com/statuses/user_timeline/$user.xml";
   $file = @file_get_contents($url);
   if (!strlen($file)) return array(FALSE);
   
   $xml  = @simplexml_load_string($file);
   if ($xml == FALSE) return array(FALSE);
   
   $tweets = array();

   foreach ($xml->status as $tweet)
   {
      $timestamp = strtotime($tweet->created_at);
      $tweets[] = "(" . date("M jS, g:ia", $timestamp) . ") " .
         $tweet->text;
   }

   return array(count($tweets), $tweets);
}

?>
