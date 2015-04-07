<?php // 插件91：根据IP确定用户所在的国家
/*
* 根据IP确定用户所在的国家
* 插件说明：
* 插件接受一个IP地址，然后返回该IP地址所在的国家。
* 如果操作失败，返回FALSE
* 它需要以下参数：
* $IP 一个IP地址
*/
/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$ip     = '127.0.0.1';
$result = DOPHP_GetCountryFromIP($ip);

if (!$result) echo "Could not identify location for '$ip'.";
else          echo "The location of '$ip' is: $result.";

function DOPHP_GetCountryFromIP($ip)
{

   $iptemp = explode('.', $ip);
   $ipdec  = $iptemp[0] * 256 * 256 * 256 +
             $iptemp[1] * 256 * 256 +
             $iptemp[2] * 256 +
             $iptemp[3];
   $file  = file_get_contents('ips.txt');
   if (!strlen($file)) return FALSE;

   $lines = explode("\n", $file);

   foreach($lines as $line)
   {
      if (strlen($line))
      {
         $parts = explode(',', trim($line));

         if ($ipdec >= $parts[0] && $ipdec <= $parts[1])
            return $parts[2];
      }
   }

   return FALSE;
}

?>
