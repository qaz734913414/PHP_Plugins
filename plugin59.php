<?php // 插件59：改变表情符号

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text = <<<_END
<table width='100%' border='0'><tr><td><pre><center>
angry >:(
blank :|
blush :X
cool  B-)
</center></pre></td><td><pre><center>
cry   :-(
dizzy *-*
happy :-)
kiss  =*
</center></pre></td><td><pre><center>
laugh   :D
puzzled O.o
sad     :(
shocked :o
</center></pre></td><td><pre><center>
sleep  I-)
smiley :)
sneaky :->
tongue :p
</center></pre></td><td><pre><center>
uhoh    =-o
uneasy  :/
wideeye 8)
wink    ;)
</center></pre></td></tr></table>
_END;

echo DOPHP_ReplaceSmileys($text, 'smileys/');

function DOPHP_ReplaceSmileys($text, $folder)
{
/*
 * 插件说明：
 * 插件接受一个字符串，查找它的情感图标，并把它替换为FIG表情符。
 * 这需要以下参数：
 * $text 代表感情的图标文本。
 * $folder 保存GIF表情符的文件夹。
 */

   $chars = array('>:-(', '>:(', 'X-(',  'X(',
                  ':-)*', ':)*', ':-*',  ':*', '=*',
                  ':)',   ':]',
                  ':-)',  ':-]',
                  ':(',   ':C',   ':[',
                  ':-(',  ':\'(', ':_(',
                  ':O',   ':-O',
                  ':P',   ':b',   ':-P', ':-b',
                  ':D',   'XD',
                  ';)',   ';-)',
                  ':/',   ':\\',  ':-/', ':-\\',
                  ':|',
                  'B-)',  'B)',
                  'I-)',  'I)',
                  ':->',  ':>',
                  ':X',   ':-X',
                  '8)',   '8-)',
                  '=-O',  '=O',
                  'O.o',  ':S',   ':-S',
                  '*-*',  '*_*');

   $gifs = array( 'angry',   'angry',   'angry',  'angry',
                  'kiss',    'kiss',    'kiss',   'kiss', 'kiss',
                  'smiley',  'smiley',
                  'happy',   'happy',
                  'sad',     'sad',     'sad',
                  'cry',     'cry',     'cry',
                  'shocked', 'shocked',
                  'tongue',  'tongue',  'tongue', 'tongue',
                  'laugh',   'laugh',
                  'wink',    'wink',
                  'uneasy',  'uneasy',  'uneasy', 'uneasy',
                  'blank',
                  'cool',    'cool',
                  'sleep',   'sleep',
                  'sneaky',  'sneaky',
                  'blush',   'blush',
                  'wideeye', 'wideeye',
                  'uhoh',    'uhoh',
                  'puzzled', 'puzzled', 'puzzled',
                  'dizzy',   'dizzy');

   if (substr($folder, -1) == '/')
      $folder = substr($folder, 0, -1);

   for ($j = 0 ; $j < count($gifs) ; ++$j)
      $gifs[$j] = "<image src='$folder/$gifs[$j].gif' " .
         "width='15' height='15' border='0' alt='$gifs[$j]' " .
         "title='$gifs[$j]' />";

   return str_ireplace($chars, $gifs, $text);
}

?>
