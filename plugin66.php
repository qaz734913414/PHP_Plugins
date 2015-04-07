<?php // 插件66: 打开会话

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$result = DOPHP_OpenSession();

if (!$result[0]) echo "Could not open session.";
else
{
   list($handle, $pass, $name, $email) = $result[1];

   echo "Retrieving session variables:<pre>";
   echo "Handle: $handle\n";
   echo "Pass:   $pass\n";
   echo "Name:   $name\n";
   echo "Email:  $email\n";
}

function DOPHP_OpenSession()
{
/*
 * 插件说明：
 * 打开前一个插件创建的PHP会话内容，返回会话变量的值，不需要参数。
 */
   //
   //    $result = DOPHP_OpenSession();
   //    list($h, $p, $n, $e) = $result[1];

   if (!@session_start()) return array(FALSE);
   if (!isset($_SESSION['handle'])) return array(FALSE);

   $vars = array();
   $vars[] = $_SESSION['handle'];
   $vars[] = $_SESSION['pass'];
   $vars[] = $_SESSION['name'];
   $vars[] = $_SESSION['email'];
   return array(TRUE, $vars);
}

?>
