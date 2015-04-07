<?php // 插件3：友好的文本

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$speech = "<h3>Winston Churchill: 'We will never surrender'</h3>I have, myself, full confidence that if all do their duty, if nothing is neglected, and if the best arrangements are made, as they are being made, we shall prove ourselves once again able to defend our Island home, to ride out the storm of war, and to outlive the menace of tyranny, if necessary for years, if necessary alone.<br />&nbsp;&nbsp;&nbsp;At any rate, that is what we are going to try to do. That is the resolve of His Majesty's Government - every man of them. That is the will of Parliament and the nation.<br />&nbsp;&nbsp;&nbsp;Even though large tracts of Europe and many old and famous States have fallen or may fall into the grip of the Gestapo and all the odious apparatus of Nazi rule, we shall not flag or fail.<br />&nbsp;&nbsp;&nbsp;We shall go on to the end, we shall fight in France, we shall fight on the seas and oceans, we shall fight with growing confidence and growing strength in the air, we shall defend our Island, whatever the cost may be, we shall fight on the beaches, we shall fight on the landing grounds, we shall fight in the fields and in the streets, we shall fight in the hills; we shall never surrender.";

echo DOPHP_FriendlyText($speech, TRUE);

function DOPHP_FriendlyText($text, $emphasis)
{
   /*
    插件3接受一个字符串变量，它代表需要转换的英文文本，需要把它转变为比较有好的格式，返回转换后的英文文本。它需要以下参数：
    $text 字符串变量，包含需要修改的文本
    $empasis 布尔变量，如果实true，则用下划线表示修改过的内容
    */

   $misc = array("let us", "let's", "i\.e\.", "for example",
      "e\.g\.", "for example", "cannot", "can't", "can not",
      "can't", "shall not", "shan't", "will not", "won't");
   $nots = array("are", "could", "did", "do", "does", "is",
      "had", "has", "have", "might", "must", "should", "was",
      "were", "would");
   $haves = array("could", "might", "must", "should", "would");
   $who = array("he", "here", "how", "I", "it", "she", "that",
      "there", "they", "we", "who", "what", "when", "where",
      "why", "you");
   $what = array("am", "are", "had", "has", "have", "shall",
      "will", "would");
   $contraction = array("m", "re", "d", "s", "ve", "ll", "ll",
      "d");

   for ($j = 0 ; $j < sizeof($misc) ; $j += 2)
   {
      $from = $misc[$j];
      $to   = $misc[$j+1];
      $text = DOPHP_FT_FN1($from, $to, $text, $emphasis);
   }

   for ($j = 0 ; $j < sizeof($nots) ; ++$j)
   {
      $from = $nots[$j] . " not";
      $to   = $nots[$j] . "n't";
      $text = DOPHP_FT_FN1($from, $to, $text, $emphasis);
   }
   
   for ($j = 0 ; $j < sizeof($haves) ; ++$j)
   {
      $from = $haves[$j] . " have";
      $to   = $haves[$j] . "'ve";
      $text = DOPHP_FT_FN1($from, $to, $text, $emphasis);
   }

   for ($j = 0 ; $j < sizeof($who) ; ++$j)
   {
      for ($k = 0 ; $k < sizeof($what) ; ++$k)
      {
         $from = "$who[$j] $what[$k]";
         $to   = "$who[$j]'$contraction[$k]";
         $text = DOPHP_FT_FN1($from, $to, $text, $emphasis);
      }
   }

   $to = "'s";
   $u1 = $u2 = "";

   if ($emphasis)
   {
      $u1 = "<u>";
      $u2 = "</u>";
   }

   return preg_replace("/([\w]*) is([^\w]+)/", "$u1$1$to$u2$2",
      $text);
}

function DOPHP_FT_FN1($f, $t, $s, $e)
{
   $uf = ucfirst($f);
   $ut = ucfirst($t);
   
   if ($e)
   {
      $t  = "<u>$t</u>";
      $ut = "<u>$ut</u>";
   }
   
   $s   = preg_replace("/([^\w]+)$f([^\w]+)/",  "$1$t$2",  $s);
   return preg_replace("/([^\w]+)$uf([^\w]+)/", "$1$ut$2", $s);
}

?>
