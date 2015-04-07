<?php // 插件70：根据cookie值阻止用户访问

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$handle = "troll23";
$pass   = "itroll4fun";
$name   = "Ivor Bigun";
$email  = "troll@underbridge.com";

echo DOPHP_BlockUserByCookie(NULL, $handle, NULL);
$result = DOPHP_CreateSession($handle, $pass, $name, $email);

if (!$result) echo "Could not create session.";
else
{
   echo 'Session created.<br /><pre>';
   echo 'Testing: $_SESSION[\'handle\'] = ' .
      $_SESSION['handle'] . '</pre>';

   $result = DOPHP_OpenSession();

   if (!$result[0]) echo "Could not open session.";
   else
   {
      list($handle, $pass, $name, $email) = $result[1];

      echo "Retrieving session variables:<pre>";
      echo "Handle: $handle\n";
      echo "Pass:   $pass\n";
      echo "Name:   $name\n";
      echo "Email:  $email</pre>";
   }
   
   $result = DOPHP_BlockUserByCookie('block', $handle,
      60 * 60 * 24 *365);

   if ($result) echo "User '$handle' blocked.";
   else echo "Blocking was unsuccessful.";
}

function DOPHP_BlockUserByCookie($action, $handle, $expire)
{
/*
 * 插件说明：
 * 根据cookie值阻止用户访问
 * 插件在用户的浏览器里设置一个cookie，利用这个cookie可以判断这个用户是否列在黑名单上。它需要以下参数：
 * $action 采取的动作
 * $handle 要阻止的用户名。
 * $expire cookie的有效时间，单位为妙。
 */

   if (strtolower($action) == 'block')
   {
      if ($_SESSION['handle'] != $handle) return FALSE;
      else return DOPHP_manageCookie('set', 'user', $handle,
         $expire, '/');
   }

   return DOPHP_ManageCookie('read', 'user', NULL, NULL, NULL);
}


function DOPHP_ManageCookie($action, $cookie, $value, $expire,
   $path)
{
   // Plug-in 69: Manage Cookie

   switch(strtolower($action))
   {
      case 'set':
         if ($expire) $expire += time();
         return setcookie($cookie, $value, $expire, $path);

      case 'read':
         if (isset($_COOKIE[$cookie]))
            return $_COOKIE[$cookie];
         else return FALSE;

      case 'delete':
         if (isset($_COOKIE[$cookie]))
            return setcookie($cookie, NULL,
               time() - 60 * 60 * 24 * 30, NULL);
         else return FALSE;
   }
   
   return FALSE;
}

function DOPHP_CreateSession($handle, $pass, $name, $email)
{
   // Plug-in 65: Create Session

   if (!session_start()) return FALSE;

   $_SESSION['handle'] = $handle;
   $_SESSION['pass']   = $pass;
   $_SESSION['name']   = $name;
   $_SESSION['email']  = $email;
   $_SESSION['ipnum']  = getenv("REMOTE_ADDR");
   $_SESSION['agent']  = getenv("HTTP_USER_AGENT");

   return TRUE;
}

function DOPHP_OpenSession()
{
   // Plug-in 66: Open Session

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