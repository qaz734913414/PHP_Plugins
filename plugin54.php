<?php // 插件54：发送聊天信息

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

if (!isset($_POST['from']))
{
echo <<<_END
<form method=post action="$_SERVER[PHP_SELF]"><pre>
   From: <input type=text name='from' />
     To: <input type=text name='to' />
Message: <input type=text name='message' />
         <input type=submit value='Post Message' />
</pre></form>
_END;
exit;
}

$from      = $_POST['from'];
$to        = $_POST['to'];
$message   = $_POST['message'];
$maxposts  = 20;
$maxlength = 1024;

$result = DOPHP_PostToChat('chatroom.txt', $maxposts,
   $maxlength, $from, $to, $message, 'off');

echo "<b>First posting of message</b><br />";
echo "Message '$message' from user '$from' to user '$to': <i>";

if ($result == 1)      echo "Successfully posted";
elseif ($result == -1) echo "Not posted (Could not access file)";
elseif ($result == -2) echo "No message to post or illegal '|'";
else                   echo "Not posted due to flooding control";

$result = DOPHP_PostToChat('chatroom.txt', $maxposts,
   $maxlength, $from, $to, $message, 'off');
   
echo "</i><br /><br /><b>Posted again with no flooding control...</b><br />";
echo "Message '$message' from user '$from' to user '$to': <i>";

if ($result == 1)      echo "Successfully posted";
elseif ($result == -1) echo "Not posted (Could not access file)";
elseif ($result == -2) echo "No message to post or illegal '|'";
else                   echo "Not posted due to flooding control";

$result = DOPHP_PostToChat('chatroom.txt', $maxposts,
   $maxlength, $from, $to, $message, 'on');

echo "</i><br /><br /><b>..and with flooding control</b><br />";
echo "Message '$message' from user '$from' to user '$to': <i>";

if ($result == 1)      echo "Successfully posted";
elseif ($result == -1) echo "Not posted (Could not access file)";
elseif ($result == -2) echo "No message to post or illegal '|'";
else                   echo "Not posted due to flooding control";

function DOPHP_PostToChat($datafile, $maxposts, $maxlength,
   $from, $to, $message, $floodctrl)
{
/*
 * 插件说明：
 * 插件将向一个聊天室发送一个聊天信息并支持几个参数。若发送成功，则本插件返回1，如果文件不能写入，则返回-1。
 * 如果用泛洪控制阻止一个重复内容，则返回0。如果$message为空内容或者在$to或者$from里包含非法符合，则返回-2。
 * 本插件需要输入以下参数：
 * $datafile 字符串，表示聊天记录文件保存的位置。
 * $maxposts 一次可以保留的最多聊天记录数。
 * $maxlength 聊天记录的最大长度，单位为字符。
 * $from 发送聊天消息的用户名。
 * $to 接收聊天消息的用户名，如果为空，则表示聊天内容可以公开。
 * $message 聊天内容。
 * $floodctrl 泛洪控制，如果值为on，同一个用户的重复内容不可以重复发送$maxposts次。
 */

   if (!file_exists($datafile))
   {
      $data = "";
      for ($j = 0 ; $j < $maxposts ; ++$j) $data .= "$j|||\n";
      file_put_contents($datafile, $data);
   }

   if ($message == "" || strpos($from, '|') ||
      strpos($to, '|')) return -2;

   $message = str_replace('|',  '|', $message);
   $message = substr($message, 0, $maxlength);
   $fh      = fopen($datafile, 'r+');
   if (!$fh) return -1;

   flock($fh, LOCK_EX);
   fgets($fh);
   $text = fread($fh, 100000);

   if (strtolower($floodctrl) == 'on' &&
      strpos($text, "|$to|$from|$message\n"))
   {
      flock($fh, LOCK_UN);
      fclose($fh);
      return 0;
   }

   $lines = explode("\n", $text);
   $temp  = explode('|', $lines[$maxposts - 2]);
   $text .= ($temp[0] + 1) . "|$to|$from|$message\n";
   fseek($fh, 0);
   fwrite($fh, $text);
   ftruncate($fh, strlen($text));
   flock($fh, LOCK_UN);
   fclose($fh);
   return 1;
}

?>
