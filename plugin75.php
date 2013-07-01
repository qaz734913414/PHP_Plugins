<?php // 插件75：获取Yahoo! Answers

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$search = "gardening tips";
$result = DOPHP_GetYahooAnswers($search);

if (!$result[0]) echo "No matching questions found for $search.";
else
   foreach($result[1] as $qa)
      echo "<b>$qa[0]</b> (" . date('M \'y', $qa[1]) . ')<br />'.
           "<b>Q.</b> <i>$qa[2]</i><br />" .
           "<b>A.</b> $qa[3]<br />" .
           "<a href='$qa[4]'>Original Question</a><br /><br />";

function DOPHP_GetYahooAnswers($search)
{
/*
 * 获取Yahoo！Answers
 * 插件说明：
 * 插件接受一个搜索关键词，返回在Yaoo!Answers上找到的结果。
 * 若操作成功，则返回一个两元素数组，第一个元素值为返回的问答题的个数，第二个参数是一个数组，
 * 数组的每个元素又是一个子数组，子数组含有以下五个值：
 *     主题
 *     Unix时间戳，表示该问题发帖的时间
 *     题目
 *     答案
 *     指向原来的Q&Q的URL地址
 * 若操作失败，则返回单个元素的数组，元素值为FALSE。
 * 本插件需要以下参数：
 * $search 搜索串
 */

   $search = rawurlencode($search);
   $id     = 'YahooDemo'; // Use your own API key here
   $url    = 'http://answers.yahooapis.com' .
             '/AnswersService/V1/questionSearch' .
             "?appid=$id&query=$search";
   $xml    = @file_get_contents($url);
   if (!$xml) return array(FALSE);

   $sxml   = simplexml_load_string($xml);
   $qandas = array();

   foreach($sxml->Question as $question)
   {
      $s = trim($question->Subject);
      $t = $question->Timestamp + 0;
      $q = trim($question->Content);
      $a = trim($question->ChosenAnswer);
      $l = $question->Link;
      
      $s = str_replace("\n", '<br />', htmlentities($s));
      $q = str_replace("\n", '<br />', htmlentities($q));
      $a = str_replace("\n", '<br />', htmlentities($a));

      if (strlen($a)) $qandas[] = array($s, $t, $q, $a, $l);
   }

   return array(count($qandas), $qandas);
}

?>
