<?php // Plug-in 89: Words From Root

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$out = "";
$max = 5;

if (!isset($_GET['word'])) exit;
if (isset($_GET['max'])) $max = $_GET['max'];

$result = DOPHP_WordsFromRoot($_GET['word'],
   'dictionary.txt', $max);

if ($result != FALSE)
   foreach ($result as $word) $out .= "$word|";

echo substr($out, 0, -1);

function DOPHP_WordsFromRoot($word, $filename, $max)
{
   // Plug-in 89: Words From Root

   $dict  = file_get_contents($filename);
   preg_match_all('/\b' . $word . '[\w ]+/', $dict, $matches);
   $c     = min(count($matches[0]), $max);
   $out   = array();
   for ($j = 0 ; $j < $c ; ++$j) $out[$j] = $matches[0][$j];
   return $out;
}

?>
