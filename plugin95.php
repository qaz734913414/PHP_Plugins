<?php // 插件95：模式匹配单词

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$word = "S.e.--&$*&%$t.ng";
$result = DOPHP_PatternMatchWord($word, 'dictionary.txt');

if ($result[0] != FALSE)
{
   echo "Matches for <font face='Courier New'>" .
        "'$word'</font>:<br><ul>";
   foreach ($result[1] as $match)
      echo "<li>$match</li>";
}

function DOPHP_PatternMatchWord($word, $dictionary)
{
/*
* 模式匹配单词
* 插件说明：
* 插件接受一个单词模式，返回一个两元素数组，其中第一个元素的值表示相匹配的单词个数，第二个元素保存单词本身。
* 若操作失败，则返回一个元素的数组，元素的值为FALSE。
* 它需要以下参数：
* $word 由字母和句点组成的单词（句点表示未知字母）
* $dictionary 字典文件和路径。
*/

   $dict = @file_get_contents($dictionary);
   if (!strlen($dict)) return array(FALSE);
   $word = preg_replace('/[^a-z\.]/', '', strtolower($word));
   preg_match_all('/\b' . $word . '\b/', $dict, $matches);
   return array(count($matches[0]), $matches[0]);
}

?>
