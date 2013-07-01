<?php // 插件67：关闭会话

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

$result = DOPHP_CloseSession();

if ($result == TRUE) echo "Session closed.";
else echo "Session close failed.";

function DOPHP_CloseSession()
{
/*
 *插件说明：
 *插件关闭已经打开的session的PHP会话，并销毁与这个会话有关的任何参数。不需要参数。 
 */

	$_SESSION = array();

	if (session_id() != "" ||
       isset($_COOKIE[session_name()]))
	   setcookie(session_name(), '', time() - 2592000, '/');

	return @session_destroy();
}

// The plug-in below is included here to ensure it is available
// to the main plug-in which relies on it

function DOPHP_OpenSession()
{

   //    $result = DOPHP_ReadSession();
   //    list($h, $p, $n, $e) = $result[1];

   if (!session_start()) return array(FALSE);
   if (!isset($_SESSION['handle'])) return array(FALSE);

   $vars = array();
   $vars[] = $_SESSION['handle'];
   $vars[] = $_SESSION['pass'];
   $vars[] = $_SESSION['name'];
   $vars[] = $_SESSION['email'];
   return array(TRUE, $vars);
}

?>
