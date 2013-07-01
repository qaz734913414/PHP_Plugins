<?php // 插件1：文本换行

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$text = "Treats of the place where Oliver Twist was born, and of the circumstances attending his birth.\nAmong other public buildings in a certain town, which for many reasons it will be prudent to refrain from mentioning, and to which I will assign no fictitious name, there is one anciently common to most towns, great or small: to wit, a workhouse; and in this workhouse was born; on a day and date which I need not trouble myself to repeat, inasmuch as it can be of no possible consequence to the reader, in this stage of the business at all events; the item of mortality whose name is prefixed to the head of this chapter.\nFor a long time after it was ushered into this world of sorrow and trouble, by the parish surgeon, it remained a matter of considerable doubt whether the child would survive to bear any name at all; in which case it is somewhat more than probable that these memoirs would never have appeared; or, if they had, that being comprised within a couple of pages, they would have possessed the inestimable merit of being the most concise and faithful specimen of biography, extant in the literature of any age or country.";

echo "<font face='Courier New' size='2'>";
echo DOPHP_WrapText($text, 71, 5);

function DOPHP_WrapText($text, $width, $indent)
{
/*
插件说明：
插件1接受一个任意的字符串变量，在合适的位置插入<br/>和"&nbsp",并且设置段首缩进一定距离。它需要三个参数：
$text:需要换行的字符串变量。
$width:整数，表示在这个位置强制文本换行。
$indent:整数，表示段首缩进的字符个数。
*/

   $wrapped    = "";
   $paragraphs = explode("\n", $text);

   foreach($paragraphs as $paragraph)
   {
      if ($indent > 0) $wrapped .= str_repeat("&nbsp;", $indent);
      
      $words = explode(" ", $paragraph);
      $len   = $indent;

      foreach($words as $word)
      {
         $wlen = strlen($word);

         if (($len + $wlen) < $width)
         {
            $wrapped .= "$word ";
            $len     += $wlen + 1;
         }
         else
         {
            $wrapped = trim($wrapped);
            $wrapped .= "<br />\n$word ";
            $len     =  $wlen;
         }
      }

      $wrapped = trim($wrapped);
      $wrapped .= "<br />\n";
   }

   return $wrapped;
}

?>
