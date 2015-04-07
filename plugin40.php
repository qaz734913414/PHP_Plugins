<?php // 插件40：Pound代码

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$string = <<<TEST
This is a test of #comicPound Code#-<br /><br />
#2Size 2#-
#4Size 4#-
#6Size 6#-<br />
#iitalic#i-
#red#bbold red#b-#-
#uunderline#u-
#sstrikethrough#s-<br />
TEST;

echo DOPHP_PoundCode($string);

function DOPHP_PoundCode($text)
{
/*
插件说明：
插件接受一个包含Pound代码的字符串，把它转化为安全的HTML代码，返回转换后的结果。他需要以下参数：
$text:需要转换的文本。
*/

   $names = array('#georgia', '#arial',   '#courier',
                  '#script',  '#impact',  '#comic',
                  '#chicago', '#verdana', '#times');
   $fonts = array('Georgia',  'Arial',    'Courier New',
                  'Script',   'Impact',   'Comic Sans MS',
                  'Chicago',  'Verdana',  'Times New Roman');
   $to    = array();
   
   for ($j = 0 ; $j < count($names) ; ++$j)
      $to[] = "<font face='$fonts[$j]'>";
      
   $text = str_ireplace($names, $to, $text);

   $text = preg_replace('/#([bius])-/i', "</$1>",
      $text);
   $text = preg_replace('/#([bius])/i',  "<$1>",
      $text);
   $text = preg_replace('/#([1-7])/',    "<font size='$1'>",
      $text);
   $text = preg_replace('/#([a-z]+)/i',  "<font color='$1'>",
      $text);
   $text = str_replace('#-', "</font>", $text);

   return $text;
}

?>
