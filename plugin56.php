<?php // 插件56：发送Tweet

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$user   = 'twitteruser';
$pass   = 'twitterpass';
$text   = 'Check out the book Plug-in PHP!';
$result = DOPHP_SendTweet($user, $pass, $text);

if ($result) echo "Tweet '$text' sent";
else echo "亲，访问推特要翻墙滴~";

function DOPHP_SendTweet($user, $pass, $text)
{
/*
 * 插件说明：
 * 插件接受一个Twitter用户名、口令和一个需要发送的信息，然后把这个消息发送到这个用户的账户里。若发送成功，则返回TRUE，否则，返回FALSE。
 * 它需要以下参数：
 * $user Twitter用户名。
 * $pass $user用户的口令。
 * $text 是最长140字符的消息。
 */

   $text = substr($text, 0, 140);
   $url  = 'http://twitter.com/statuses/update.xml';
   $curl_handle = curl_init();
   curl_setopt($curl_handle, CURLOPT_URL, "$url");
   curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
   curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl_handle, CURLOPT_POST, 1);
   curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$text");
   curl_setopt($curl_handle, CURLOPT_USERPWD, "$user:$pass");
   $result = curl_exec($curl_handle);
   curl_close($curl_handle);

   $xml = simplexml_load_string($result);
   if ($xml == FALSE) return FALSE;
   elseif ($xml->text == $text) return TRUE;
   else return FALSE;
}

?>
