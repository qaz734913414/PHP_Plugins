<?php // 插件92：忽略检测码或检测字

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$result = DOPHP_CaptchaBypass();
if (!$result) echo "A Captcha <b>should</b> probably be used.";
else echo "A Captcha probably <b>isn't</b> required.";

echo "<br /><a href='$_SERVER[PHP_SELF]'>Now click here</a>";

function DOPHP_CaptchaBypass()
{
/*
* 忽略检测码或检测字
* 插件说明：
* 插件不接受任何参数，但是如果认为当前用户是人，则返回TRUE,否则返回FALSE
*/
   if (isset($_SERVER['HTTP_REFERER']) &&
       isset($_SERVER['HTTP_USER_AGENT']))
         return TRUE;
   return FALSE;
}

?>
