<?php // 插件68：保证会话安全

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$result = DOPHP_OpenSession();

if (!$result[0]) echo "Could not open session.<br />";
else
{
   list($handle, $pass, $name, $email) = $result[1];

   echo "Retrieving session variables:<pre>";
   echo "Handle: $handle\n";
   echo "Pass:   $pass\n";
   echo "Name:   $name\n";
   echo "Email:  $email</pre>";
}

if (DOPHP_SecureSession()) echo "Session is secure.";
else echo "No session (or unsecured: now terminated).";

function DOPHP_SecureSession()
{
/*
 * 插件说明：
 * 插件用于检查某个会话是否安全，如果它不安全，就关闭它。它不需要任何参数。
 * 黑客攻击会利用“劫持”PHP会话。可以有多种方式实现，但是一个严重的安全漏洞就是黑客通过GET URL字符串尾确定会话ID的网站。
 * 凭借这些信息黑客可以启动一个会话，然后通过垃圾信息或其他连接传递这个URL地址，然后他们通过这个地址返回，并搜索这些链接正在被使用的蛛丝马迹，
 * 如果发现这个用户还没推出，他们就可以劫持这个会话并以他的身份访问这个网站。
 */
   
   $ipnum = getenv("REMOTE_ADDR");
   $agent = getenv("HTTP_USER_AGENT");

   if (isset($_SESSION['ipnum']))
   {
      if ($ipnum != $_SESSION['ipnum'] ||
         $agent != $_SESSION['agent'])
      {
         DOPHP_CloseSession();
         return FALSE;
      }
      else return TRUE;
   }
   else return FALSE;
}

// The plug-ins below are included here to ensure they
// are available to the main plug-in which relies on them

function DOPHP_OpenSession()
{

   if (!session_start()) return array(FALSE);
   if (!isset($_SESSION['handle'])) return array(FALSE);

   $vars = array();
   $vars[] = $_SESSION['handle'];
   $vars[] = $_SESSION['pass'];
   $vars[] = $_SESSION['name'];
   $vars[] = $_SESSION['email'];
   return array(TRUE, $vars);
}

function DOPHP_CloseSession()
{

	$_SESSION = array();

	if (session_id() != "" ||
       isset($_COOKIE[session_name()]))
	   setcookie(session_name(), '', time() - 2592000, '/');

	return @session_destroy();
}

?>
