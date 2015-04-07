<?php // 插件89：词根提示

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

if (!isset($_GET['word']))
   exit;

$result = DOPHP_WordsFromRoot($_GET['word'],
   'dictionary.txt', 20);
if ($result != FALSE)
   foreach ($result as $word)
      echo "$word<br />";

function DOPHP_WordsFromRoot($word, $filename, $max)
{
/*
插件说明：
插件89接受一个单词的几个首字母，返回字典中所有以这些字母开头的单词或短语。它需要以下参数：
$word 词根
$filename 字典文件的路径
$max 返回单词或短语的最大个数
*/

   $dict  = file_get_contents($filename);
   preg_match_all('/' . $word . '[\w ]+/', $dict, $matches);
   $c     = min(count($matches[0]), $max);
   $out   = array();
   for ($j = 0 ; $j < $c ; ++$j) $out[$j] = $matches[0][$j];
   return $out;
}

?>
