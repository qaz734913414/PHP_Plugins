<?php // 插件80：汇率换算

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$amount = 100;
$from   = 'USD';
$to     = 'GBP';

$result = DOPHP_ConvertCurrency(100, $from, $to);
if (!$result) echo "Conversion failed.";
else echo "$amount $from is $result $to";

function DOPHP_ConvertCurrency($amount, $from, $to)
{
/*
 * 汇率换算
 * 插件说明：
 * 插件接受一个数值，把它从一种外汇换上成另一种外汇，
 * 若换算成功，则返回一个浮点数，准确到小数点的两位数，它表示个顶外汇转换新外汇后的金额。
 * 若换算失败，则返回false。
 * 它需要三个参数：
 * $amount 需要换算的金额
 * $from 源外汇的缩写
 * $to 目标外汇的缩写
 */

   //    AUD, BGN, BRL, CAD, CHF, CNY, CZK, DKK, EEK, EUR, GBP,
   //    HKD, HRK, HUF, IDR, INR, JPY, KRW, LTL, LVL, MXN, MYR,
   //    NOK, NZD, PHP, PLN, RON, RUB, SEK, SGD, THB, TRY, USD,
   //    ZAR

   $url   = 'http://www.ecb.europa.eu/stats/eurofxref/' .
            'eurofxref-daily.xml';
   $data  = file_get_contents($url);
   if (!strlen($data)) return FALSE;

   $ptr1  = strpos($data, '<Cube currency');
   $ptr2  = strpos($data, '</Cube>');
   $data  = substr($data, $ptr1, $ptr2 - $ptr1);
   $data  = str_replace("<Cube currency='", '', $data);
   $data  = str_replace("' rate='",        '|', $data);
   $data  = str_replace("'/>",             '@', $data);
   $data  = preg_replace("/\s/",            '', $data);
   $main  = array();
   $lines = explode('@', substr($data, 0, -1));

   foreach($lines as $line)
   {
      list($l, $r) = explode('|', $line);
      $main[$l]    = $r;
   }

   $main['EUR'] = 1;
   $from        = strtoupper($from);
   $to          = strtoupper($to);
   
   if (!isset($main[$from]) || !isset($main[$to])) return FALSE;
   return sprintf('%.02f', $amount / $main[$from] * $main[$to]);
}

?>
