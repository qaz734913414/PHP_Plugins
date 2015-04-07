<?php // 插件8：拼写检查

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text = "It was the best of tmes, it was the wrst of times, it was the age of wisdom, it was the age of foolishnes, it was the epoch of beleif, it was the epoch of incredulity, it was the season of Light, it was the season of Darkness, it was the spring of hope, it was the winter of despare, we had eveything before us, we had nothing before us, we were all going drect to heaven.";

echo "$text<br /><br />";
echo DOPHP_SpellCheck($text, "u");

function DOPHP_SpellCheck($text, $action)
{
/*
插件说明：
插件8需要两个参数。一个代表需要拼写检查的字符串，另一个表示拼写检查后文本的显示方式。它们是：
$text 字符串变量，表示需要拼写检查的文本。
$action 字符串变量，它是一个字母，表示文本显示的格式。
*/

   $dictionary = DOPHP_SpellCheckLoadDictionary("dictionary.txt");
   $text      .= ' ';
   $newtext    = "";
   $offset     = 0;

   while ($offset < strlen($text))
   {
      preg_match('/[^\w]*([\w]+)[^\w]+/',
         $text, $matches, PREG_OFFSET_CAPTURE, $offset);
      $word   = $matches[1][0];
      $offset = $matches[0][1] + strlen($matches[0][0]);
      
      if (!DOPHP_SpellCheckWord($word, $dictionary))
         $newtext .= "<$action>$word</$action> ";
      else $newtext .= "$word ";
   }
   
   return rtrim($newtext);
}

function DOPHP_SpellCheckLoadDictionary($filename)
{
   return explode("\r\n", file_get_contents($filename));
}

function DOPHP_SpellCheckWord($word, $dictionary)
{
   $top = sizeof($dictionary) -1;
   $bot  = 0;
   $word = strtolower($word);

   while($top >= $bot)
   {
      $p =   floor(($top + $bot) / 2);
      if     ($dictionary[$p] < $word) $bot = $p + 1;
      elseif ($dictionary[$p] > $word) $top = $p - 1;
      else   return TRUE;
   }
     
   return FALSE;
}

?>