<?php // 插件96：单词拼写提示

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$word = 'spenr';
echo "Suggested spellings for '$word':<br /><ul>";

$results = DOPHP_SuggestSpelling($word, 'dictionary.txt');
if (!$results[0]) echo "No suggested spellings.";
else foreach ($results[1] as $spelling)
   echo "<li>$spelling</li>";

function DOPHP_SuggestSpelling($word, $dictionary)
{
/*
* 单词拼写提示
* 插件说明：
* 插件接受一个无法识别的单词，返回最接近它的单词。
* 若操作成功，则返回两个元素的数组，其中第一个元素表示返回单词的个数，第二个元素是一个单词数组。
* 若操作失败，则返回一个一元素的数组，元素的值为FALSE。
* 它需要以下参数：
* $word 一个单词
* $dictionary 字典文件的路径。
*/

   if (!strlen($word)) return array(FALSE);

   static $count, $words;

   if ($count++ == 0)
   {
      $dict = @file_get_contents($dictionary);
      if (!strlen($dict)) return array(FALSE);
      $words = explode("\r\n", $dict);
   }

   $possibles = array();
   $known     = array();
   $suggested = array();
   $wordlen   = strlen($word);
   $chars     = str_split('abcdefghijklmnopqrstuvwxyz');

   for($j = 0 ; $j < $wordlen ; ++$j)
   {
       //单词中去掉一个字母
      $possibles[] =    substr($word, 0, $j) .
                        substr($word, $j + 1);
      //对单词替换一个字母 
      foreach($chars as $letter)
         $possibles[] = substr($word, 0, $j) .
                        $letter .
                        substr($word, $j + 1);
   }

   for($j = 0; $j < $wordlen - 1 ; ++$j)
      //单词中两个字母交换位置
      $possibles[] =    substr($word, 0, $j) .
                        $word[$j + 1] .
                        $word[$j] .
                        substr($word, $j +2 );

   for($j = 0; $j < $wordlen + 1 ; ++$j)
      foreach($chars as $letter)
	     //单词中插入一个新的字母
         $possibles[] = substr($word, 0, $j).
                        $letter.
                        substr($word, $j);
   //所有以上四种情况的单词与字典中单词对比，如果字典中存在，返回到$known中。
   $known = array_intersect($possibles, $words);
   $known = array_count_values($known);
   arsort($known, SORT_NUMERIC);

   foreach ($known as $temp => $val)
      $suggested[] = $temp;

   return array(count($suggested), $suggested);
}

?>
