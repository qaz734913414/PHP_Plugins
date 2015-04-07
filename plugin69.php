<?php // 插件69：管理cookie

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$cookie = 'Test';
$value  = '3.1415927';
$expire = 300;
$path   = '/';

$result = DOPHP_ManageCookie('read', $cookie, NULL, NULL, NULL);

if (DOPHP_ManageCookie('set', $cookie, $value, $expire, $path))
   echo "Cookie '$cookie' set to value '$value'";
else echo 'Setting of cookie failed';

echo "<br />The read value of '$cookie' is '$result'";
echo '<br />(Reload to read the cookie back).';

function DOPHP_ManageCookie($action, $cookie, $value, $expire, $path)
{
/*
 * 插件说明：
 * 管理Cookie
 * 插件可以给Cookie变量设置值，可以读取Cookie变量的值，甚至可以删除cookie变量。
 * 需要以下参数：
 * $action 对cookie采取的动作：设置值，读取和删除。
 * $cookie cookie变量名
 * $value cookie变量值
 * $expire cookie变量的有效期限，单位为妙
 * $path 服务器上cookie路径
 */

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

?>
