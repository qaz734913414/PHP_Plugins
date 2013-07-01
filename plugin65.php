<?php // 插件65：创建会话

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$handle = "firstprez";
$pass   = "GW022232";
$name   = "George Washington";
$email  = "george@washington.com";
$result = DOPHP_CreateSession($handle, $pass, $name, $email);

if (!$result) echo "Could not create session.";
else
{
   echo 'Session created.<br /><pre>';
   echo 'Testing: $_SESSION[\'handle\'] = ' .
      $_SESSION['handle'];
      var_dump($_SESSION);
}

function DOPHP_CreateSession($handle, $pass, $name, $email)
{
/*
 * 插件说明：
 * 创建回话
 * 插件接受前面保存到Mysql数据库里一个用户的全部信息，把它们保存到PHP会话变量里。它需要以下参数：
 * $handle 用户名
 * $pass 口令
 * $name 用户的真实名字
 * $email 用户的Email地址
 */

   if (!session_start()) return FALSE;

   $_SESSION['handle'] = $handle;
   $_SESSION['pass']   = $pass;
   $_SESSION['name']   = $name;
   $_SESSION['email']  = $email;
   $_SESSION['ipnum']  = getenv("REMOTE_ADDR");
   $_SESSION['agent']  = getenv("HTTP_USER_AGENT");

   return TRUE;
}

?>
