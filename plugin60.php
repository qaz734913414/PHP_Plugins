<?php // 插件60：转换短信语言

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$text = "FYI, afaik imho this is a cool plug-in, LOL.";

echo "<b>Before</b>: <i>$text</i><br /><br><b>After</b>: <i>" .
      DOPHP_ReplaceSMSTalk($text);

function DOPHP_ReplaceSMSTalk($text)
{
/*
 * 转换短信语言
 * 插件说明：
 * 接受一个字符串，如果它包含可识别的短信语音缩写符，就把他们转换为标准英语语句并返回。
 * 它需要以下参数：
 * $text 需要处理的文本。
 */

   $sms = array('ABT2', 'about to',
                'AFAIC', 'as far as I\'m concerned',
                'AFAIK', 'as far as I know',
                'AML', 'all my love',
                'ATST', 'at the same time',
                'AWOL', 'absent without leave',
                'AYK', 'as you know',
                'AYTMTB', 'and you\'re telling me this because?',
                'B4', 'before',
                'B4N', 'bye for now',
                'BBT', 'be back tomorrow',
                'BRB', 'be right back',
                'BTW', 'by the way',
                'BW', 'best wishes',
                'BYKT', 'but you knew that',
                'CID', 'consider it done',
                'CSL', 'can\'t stop laughing',
                'CYL', 'see you later',
                'CYT', 'see you tomorrow',
                'DGA ', 'don\'t go anywhere',
                'DIKU', 'do I know you?',
                'DLTM', 'don\'t lie to me',
                'FF', 'friends forever',
                'FYI', 'for your information',
                'GBH', 'great big hug',
                'GG', 'good game',
                'GL', 'good luck',
                'GR8', 'great',
                'GTG', 'got to go',
                'HAK', 'hugs and kisses',
                'ILU', 'I love you',
                'IM', 'instant message',
                'IMHO', 'in my humble opinion',
                'IMO', 'in my opinion',
                'IMS', 'I\'m sorry',
                'IOH', 'I\'m outta here',
                'JK', 'just kidding',
                'KISS', 'Keep it simple silly',
                'L8R', 'later',
                'LOL', 'laughing out loud',
                'M8 ', 'mate',
                'MSG', 'message',
                'N1', 'nice one',
                'NE1', 'anyone?',
                'NMP', 'not my problem',
                'NOYB', 'none of your business',
                'NP', 'no problem',
                'OMDB', 'over my dead body',
                'OMG', 'oh my gosh',
                'ONNA', 'oh no, not again',
                'OOTO', 'out of the office',
                'OT', 'off topic',
                'OTT', 'over the top',
                'PLS', 'please',
                'PM', 'personal message',
                'POOF', 'goodbye',
                'QL', 'quit laughing',
                'QT', 'cutie',
                'RBTL ', 'reading between the lines',
                'ROLF', 'rolling on the floor laughing',
                'SMEM', 'send me an email',
                'SMIM', 'send me an instant message',
                'SO', 'significant other',
                'SOHF', 'sense of humor failure',
                'STR8', 'straight',
                'SYS', 'see you soon',
                'TAH', 'take a hike',
                'TBC', 'to be continued',
                'TFH', 'thread from hell',
                'TGIF', 'thank goodness it\'s Friday',
                'THX', 'thanks',
                'TM', 'trust me',
                'TOM', 'tomorrow',
                'TTG', 'time to go',
                'TVM', 'thank you very much',
                'VM', 'voice mail',
                'WC', 'who cares?',
                'WFM', 'Works for me',
                'WTG', 'way to go',
                'WYP', 'what\'s your problem?',
                'WYWH', 'wish you were here',
                'XOXO', 'hugs and kisses',
                'ZZZ', 'sleeping, bored');

   $from1 = array(); $from2 = array();
   $to1   = array(); $to2   = array();
   
   for ($j = 0 ; $j < count($sms) ; $j += 2)
   {
      $from1[$j] = "/\b$sms[$j]\b/";
      $to1[$j]   = ucfirst($sms[$j + 1]);

      $from2[$j] = "/\b$sms[$j]\b/i";
      $to2[$j]   = $sms[$j + 1];
   }

   $text = preg_replace($from1, $to1, $text);
   return  preg_replace($from2, $to2, $text);
}

?>
