<?php // 插件6：添加后缀

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/


for ($j = 0 ; $j < 101 ; ++$j)
   echo DOPHP_CountTail($j) . ", ";


function DOPHP_CountTail($number)
{
   /*
   插件说明：
   插件6的输入参数是一个数，他返回这个数以及相应的后缀符（st, nd, rd or th ）。他只有一个参数：
   $number——需要添加后缀的数字。
   */
 
   $nstring = (string) $number;
   $pointer = strlen($nstring) - 1;
   $digit   = $nstring[$pointer];
   $suffix  = "th";


   if ($pointer == 0 ||
      ($pointer > 0 && $nstring[$pointer - 1] != 1))
   {
      switch ($nstring[$pointer])
      {
         case 1: $suffix = "st"; break;
         case 2: $suffix = "nd"; break;
         case 3: $suffix = "rd"; break;
      }
   }
   
   return $number . $suffix;
}


?>