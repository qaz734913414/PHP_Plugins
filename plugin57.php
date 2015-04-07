<?php // 插件57：直接发送tweet消息

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$user   = '4u4v';
$pass   = 'twitterpass';
$to     = 'otheruser';
$text   = 'A test message from twitteruser to otheruser';
$result = DOPHP_SendDirectTweet($user, $pass, $to, $text);

if ($result) echo "Direct Tweet '$text' sent to '$to'.";
else echo '发送失败';

function DOPHP_SendDirectTweet($user, $pass, $to, $text)
{
/*
 * 插件说明：
 * 插件接受一个Twitter账户的用户名、口令、接收者的姓名和发送内容。然后把这个消息发送给这个接收者的账户。
 * 如发送成功，返回TRUE，否则返回FALSE。
 * 它需要以下参数：
 * $user Tiwtter用户名。
 * $pass $user用户的口令。
 * $to Tweet消息直接接收者的用户名。
 * $text 最多140字的Tweet消息。
 */

   $text = substr($text, 0, 140);
   $url  = 'http://twitter.com/direct_messages/new.xml';
   $curl_handle = curl_init();
   curl_setopt($curl_handle, CURLOPT_URL, "$url");
   curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
   curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl_handle, CURLOPT_POST, 1);
   curl_setopt($curl_handle, CURLOPT_POSTFIELDS,
      "user=$to&text=$text");
   curl_setopt($curl_handle, CURLOPT_USERPWD, "$user:$pass");
   $result = curl_exec($curl_handle);
   curl_close($curl_handle);

   $xml = simplexml_load_string($result);
   if ($xml == FALSE) return FALSE;
   elseif ($xml->text == $text) return TRUE;
   else return FALSE;
}

?>
