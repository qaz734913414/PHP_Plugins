<?php // 插件2：控制大写锁定键

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$text = "THE SUN WAS SHINING ON THE SEA, SHINING WITH ALL HIS MIGHT: HE DID HIS VERY BEST TO MAKE THE BILLOWS SMOOTH AND BRIGHT - AND THIS WAS ODD, BECAUSE IT WAS THE MIDDLE OF THE NIGHT. THE MOON WAS SHINING SULKILY, BECAUSE SHE THOUGHT THE SUN HAD GOT NO BUSINESS TO BE THERE AFTER THE DAY WAS DONE";

echo DOPHP_CapsControl($text, "u") . "<br />";
echo DOPHP_CapsControl($text, "l") . "<br />";
echo DOPHP_CapsControl($text, "w") . "<br />";
echo DOPHP_CapsControl($text, "s") . "<br />";

function DOPHP_CapsControl($text, $type)
{
    /*
	插件说明：
    插件2的第一个参数代表一个字符串变量，第二个参数表示转换方式。根据第二个参数的值对字符串变量进行大小写转换。插件2需要以下参数：
$text: 字符串变量，代表需要转换的文本。
$type: 字符串，代表转换的类型：
    -u 将把所有字母转换为大写；
    -l 将把所有字母转换为小写；
   -w 将把每个单词的第一个字母转换为大写。
    -s 将把每个语句的第一个字母转换为大写。
    */
   switch($type)
   {
      case "u": return strtoupper($text);

      case "l": return strtolower($text);

      case "w":
         $newtext = "";
         $words   = explode(" ", $text);
         foreach($words as $word)
            $newtext .= ucfirst(strtolower($word)) . " ";
         return rtrim($newtext);

      case "s":
         $newtext   = "";
         $sentences = explode(".", $text);
         foreach($sentences as $sentence)
            $newtext .= ucfirst(ltrim(strtolower($sentence))) . ". ";
         return rtrim($newtext);
   }

   return $text;
}

?>
