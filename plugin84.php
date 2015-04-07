<?php // 插件84：保护Email

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$email  = 'admin@4u4v.net';
$pemail = DOPHP_ProtectEmail($email);
echo "My email address is $pemail";

function DOPHP_ProtectEmail($email)
{
/*
插件说明：
插件接受一个Email地址，返回一段Javascript代码，他把这个地址在HTML页面上显示为一个超链接形式，而不是完整的Email地址。若操作成功则返回这个Javascript程序，若失败（如，这个Email地址无效），则返回false.他需要以下参数：
$email:需要处理的Email
*/

   $t1 = strpos($email, '@');
   $t2 = strpos($email, '.', $t1);
   if (!$t1 || !$t2) return FALSE;

   $e1 = substr($email, 0, $t1);
   $e2 = substr($email, $t1, $t2 - $t1);
   $e3 = substr($email, $t2);

   return "<script>e1='$e1';e2='$e2';e3='$e3';document.write" .
          "('<a href=\'mailto:' + e1 + e2 + e3 + '\'>' + e1 " .
          "+ e2 + e3 + '</a>');</script>";
}

?>
