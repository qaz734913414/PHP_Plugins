<?php // 插件32：信用卡号码验证

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$card   = "4567 1234 5678 9101";
$exp    = "06/11";
echo "Validating: $card : $exp<br>";
$result = DOPHP_ValidateCC($card, $exp);
if ($result != FALSE) echo "Card Validated";
else echo "Card did not validate";

function DOPHP_ValidateCC($number, $expiry)
{
/*
插件说明：
插件接受一个信用卡号码和有效日期，如果两者都有效，则返回TRUE,否则返回FALSE。本插件接受以下参数：
$number 表示信用卡号码的一个字符串
$expiry 信用卡有效日期，采用07/12或0712这样的格式
*/

   $number = preg_replace('/[^\d]/', '', $number);
   $expiry = preg_replace('/[^\d]/', '', $expiry);
   $left   = substr($number, 0, 4);
   $cclen  = strlen($number);
   $chksum = 0;

   // Diners Club
   if (($left >= 3000) && ($left <= 3059) ||
       ($left >= 3600) && ($left <= 3699) ||
       ($left >= 3800) && ($left <= 3889))
      if ($cclen != 14) return FALSE;

   // JCB
   if (($left >= 3088) && ($left <= 3094) ||
       ($left >= 3096) && ($left <= 3102) ||
       ($left >= 3112) && ($left <= 3120) ||
       ($left >= 3158) && ($left <= 3159) ||
       ($left >= 3337) && ($left <= 3349) ||
       ($left >= 3528) && ($left <= 3589))
      if ($cclen != 16) return FALSE;

   // American Express
   elseif (($left >= 3400) && ($left <= 3499) ||
           ($left >= 3700) && ($left <= 3799))
      if ($cclen != 15) return FALSE;

   // Carte Blanche
   elseif (($left >= 3890) && ($left <= 3899))
      if ($cclen != 14) return FALSE;

   // Visa
   elseif (($left >= 4000) && ($left <= 4999))
      if ($cclen != 13 && $cclen != 16) return FALSE;

   // MasterCard
   elseif (($left >= 5100) && ($left <= 5599))
      if ($cclen != 16) return FALSE;
      
   // Australian BankCard
   elseif ($left == 5610)
      if ($cclen != 16) return FALSE;

   // Discover
   elseif ($left == 6011)
      if ($cclen != 16) return FALSE;

   // Unknown
   else return FALSE;

   for ($j = 1 - ($cclen % 2); $j < $cclen; $j += 2)
      $chksum += substr($number, $j, 1);

   for ($j = $cclen % 2; $j < $cclen; $j += 2)
   {
      $d = substr($number, $j, 1) * 2;
      $chksum += $d < 10 ? $d : $d - 9;
   }

   if ($chksum % 10 != 0) return FALSE;

   if (mktime(0, 0, 0, substr($expiry, 0, 2), date("t"),
      substr($expiry, 2, 2)) < time()) return FALSE;
   
   return TRUE;
}

?>
