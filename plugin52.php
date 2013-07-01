<?php // 插件52：在留言薄留言

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$name    = "Jacky";
$email   = "admin@4u4v.net";
$website = "http://shuimu.js.cn";
$message = "Don't you step on my Blue suede shoes.";

echo "Name=<i>$name</i>, Email=<i>$email</i>, Website=<i>" .
   "$website</i>, Message=<i>$message</i><br /><br />";
   
$result = DOPHP_PostToGuestBook('guestbook.txt', $name, $email,
   $website, $message);

if     ($result == 1) echo "<b>Message Posted</b><br />";
elseif ($result == 0) echo "<b>Message Ignored</b><br />";
else                  echo "<b>Message Failed</b><br />";

echo "<br />Name=<i>$name</i>, Email=<i>$email</i>, Website=" .
   "<i>$website</i>, Message=<i>$message</i><br /><br />";

$result = DOPHP_PostToGuestBook('guestbook.txt', $name, $email,
   $website, $message);

if     ($result == 1) echo "<b>Message Posted</b><br />";
elseif ($result == 0) echo "<b>Message Ignored</b><br />";
else                  echo "<b>Message Failed</b><br />";

function DOPHP_PostToGuestBook($datafile, $name, $email,
   $website, $message)
{
/*
 * 插件说明：
 * 插件用于在一个留言薄里留言，它需要以下参数：
 * $datafile 字符串变量，包含存储数据的文件的位置。
 * $name 发帖者的名字。
 * $email 发帖者的Email地址。
 * $website 发帖者的网站。
 * $message 发帖内容。
 */

   $data = $name . '!1!' . $email . '!1!' . $website .
         '!1!' . $message;
   if (file_exists($datafile))
   {
      $lines = explode("\n",
         rtrim(file_get_contents($datafile)));

      if (in_array($data, $lines)) return 0;
   }

   $fh = fopen($datafile, 'a');
   if (!$fh) return -1;

   if (flock($fh, LOCK_EX)) fwrite($fh, $data . "\n");
   flock($fh, LOCK_UN);
   fclose($fh);
   return 1;
}

?>
