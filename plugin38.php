<?php // 插件38:发送电子邮件

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$message = "Hello Fred, I hadn't heard from you recently and " .
           "thought I'd send you a quick note to see how you " .
           "are keeping. - Rick";
$subject = "How are you?";

echo "Sending <i>'$message'</i>: ";
if (DOPHP_SendEmail($message, $subject, '', 'test@163.com',
   '', 'admin@4u4v.net', NULL, NULL, ''))
      echo "<p>邮件发送成功！</p>";
else echo "邮件发送失败，请检查邮件服务器配置。";

function DOPHP_SendEmail($message, $subject, $priority, $from,
   $replyto, $to, $cc, $bcc, $type)
{
/*
插件说明：插件接受一个电子邮件内容的字符串和一个表示主题的字符串，以及与邮件接受者有关的其他参数。具体参数如下：
$message 电子邮件内容
$subject 电子邮件的主题
$priority 电子邮件的优先级别，级别1最高，级别5最低，空表示没有优先级别。
$from 电子邮件发送者的地址
$replyto 电子邮件的回复地址
$to 电子邮件接受者的地址
$cc 数组，表示电子邮件抄送的地址列表
$bcc 数组，表示电子邮件密送的地址列表（任何电子邮件接受者无法从电子邮件信息中看到电子邮件密送的地址）
$type 电子邮件类型，它的值为“HTML"表示电子邮件通过HTML格式发送，否则按文本发送.
*/

   $headers = "From: $from\r\n";

   if (strtolower($type) == "html")
   {
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=UTF-8\r\n";
   }

   if ($priority > 0)  $headers .= "X-Priority: $priority\r\n";
   if ($replyto != "") $headers .= "Reply-To: $replyto\r\n";

   if (count($cc))
   {
      $headers .= "Cc: ";
         for ($j = 0 ; $j < count($cc) ; ++$j)
            $headers .= $cc[$j] . ",";
      $headers = substr($headers, 0, -1) . "\r\n";
   }

   if (count($bcc))
   {
      $headers .= "Bcc: ";
         for ($j = 0 ; $j < count($bcc) ; ++$j)
            $headers .= $bcc[$j] . ",";
      $headers = substr($headers, 0, -1) . "\r\n";
   }

   return mail($to, $subject, $message, $headers);
}

?>
