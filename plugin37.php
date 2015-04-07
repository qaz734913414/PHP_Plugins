<?php // 插件37：截获垃圾信息

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$words  = array('rolex', 'replica', 'loan', 'mortgaqe', 'viagra',
                'cialis', 'acai', 'free', 'stock', 'guaranteed',
                'refinancing', 'cartier', 'manhood', 'drugs');

$text   = "Hi there. I enjoyed reading your website and will " .
          "be back for more. Keep up the good work!";
$result = DOPHP_SpamCatch($text, $words);
echo "The text <i>'$text'</i> is ";
echo $result == 0 ? "spam free." : "suspected spam " .
   "(score = $result).";

$text   = "Brand new replica rolex. Guaranteed quality. " .
          "http://replicarolex23.com";
$result = DOPHP_SpamCatch($text, $words);
echo "<br /><br />The text <i>'$text'</i> is ";
echo $result == 0 ? "spam free." : "suspected spam " .
   "(score = $result).";

function DOPHP_SpamCatch($text, $words)
{
/*
插件说明：
插件接受一个用户输入的字符串，把它与一个关键字表进行比较以确定这个字符串是垃圾信息的可能性，需要以下参数：
$text 需要验证的email地址
$words 用于验证的关键字数组
*/
   return strlen($text) -
      strlen(DOPHP_WordSelector($text, $words, ''));
}


function DOPHP_WordSelector($text, $matches, $replace)
{
   foreach($matches as $match)
   {
      switch($replace)
      {
         case "u":
         case "b":
         case "i":
            $text = preg_replace("/([^\w]+)($match)([^\w]+)/i",
               "$1<$replace>$2</$replace>$3", $text);
            break;

         default:
            $text = preg_replace("/([^\w]+)$match([^\w]+)/i",
               "$1$replace$2", $text);
            break;
      }
   }

   return $text;
}

?>
