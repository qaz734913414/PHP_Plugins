<?php // 插件26：显示版权

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo DOPHP_RollingCopyright("All Rights Reserved", "Tencent", 2003);

function DOPHP_RollingCopyright($message, $company, $year)
{
/*
插件说明：
本插件需要输入一个版权信息和版权的开始年份。这些参数具体如下：
$message 版权信息。
$year 版权开始的年份。
*/
   return "Copyright &copy; $year-" . date("Y") ." ".$company." ".$message;
}

?>
