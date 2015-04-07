<?php // 插件25：突出显示搜索结果

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text = "To be or not to be, that is the question; " .
        "whether 'tis nobler in the mind to suffer " .
        "the slings and arrows of outrageous fortune, " .
        "or to take arms against a sea of troubles, " .
        "and by opposing, end them. To die - to sleep, " .
        "no more; and by a sleep to say we end " .
        "the heart-ache and the thousand natural shocks " .
        "that flesh is heir to - 'tis a consummation " .
        "devoutly to be wish'd.";

echo    "<a href=\"" . $_SERVER['PHP_SELF'] .
        "?q=" . rawurlencode("question of sleep") .
        "\">Click twice to test</a><br />";
echo    DOPHP_QueryHighlight($text, "b");

function DOPHP_QueryHighlight($text, $highlight)
{
/*
插件说明
本插件接受一个文本和搜索关键字的突出显示类型。它需要以参数如下：
$text 被突出显示的文本
$highlight 被突出显示的类型，取b、i或u值
*/
	$refer = getenv('HTTP_REFERER');
	$parse = parse_url($refer);
   
	if ($refer == "") return $text;
	elseif (!isset($parse['query'])) return $text;

	$queries = explode('&', $parse['query']);

	foreach($queries as $query)
   {
      list($key, $value) = explode('=', $query);
      
      if ($key == "q" || $key == "p")
      {
         $matches = explode(' ', preg_replace('/[^\w ]/', '',
            urldecode($value)));
         return DOPHP_WordSelector($text, $matches, $highlight);
      }
   }
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
