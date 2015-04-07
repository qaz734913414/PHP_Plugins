<?php // 插件51：在线用户

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

echo "Users online: " . DOPHP_UsersOnline('users.txt', 300);

function DOPHP_UsersOnline($datafile, $seconds)
{
/*
插件说明：
插件显示最近访问一个网站的在线用户数。它需要以下参数：
$datafile 字符串，包含数据文件存储的位置。
$seconds 时间间隔，单位为秒，在此时间间隔内，访问该网站的用户被认为是活动用户。
*/

   $ip     = getenv("REMOTE_ADDR") .
             getenv("HTTP_USER_AGENT");
   $out    = "";
   $online = 1;

   if (file_exists($datafile))
   {
      $users  = explode("\n",
         rtrim(file_get_contents($datafile)));

      foreach($users as $user)
      {
         list($usertime, $userip) = explode('|', $user);

         if ((time() - $usertime) < $seconds &&
            $userip != $ip)
         {
            $out .= $usertime . '|' . $userip . "\n";
            ++$online;
         }
      }
   }

   $out .= time() . '|' . $ip . "\n";
   file_put_contents($datafile, $out);
   return $online;
}

?>
