<?php // 插件39：公告栏代码

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text = <<<CODE
This is a test of BB Code<br /><br />
[size=12]Size 12[/size]
[size=20]Size 20[/size]
[size=32]Size 32[/size]<br />
[i]italic[/i]
[color=red][b]bold red[/b][/color]
[u]underline[/u]
[s]strikethrough[/s]<br />
[url]http://google.com[/url]<br />
[url=http://yahoo.com]A titled hyperlink[/url]<br />
[quote]Block quoted text[/quote]
CODE;

echo DOPHP_BBCode($text);

function DOPHP_BBCode($string)
{
/*
插件说明：
插件接受一个包含BB代码的字符串，把它转换为安全的HTML代码并返回，他接受以下参数：
$string 需要转换的字符串。
*/

   $from   = array('[b]', '[/b]',  '[i]', '[/i]',
                   '[u]', '[/u]',  '[s]', '[/s]',
                   '[quote]',      '[/quote]',
                   '[code]',       '[/code]',
                   '[img]',        '[/img]',
                   '[/size]',      '[/color]',
                   '[/url]');
   $to     = array('<b>', '</b>',  '<i>', '</i>',
                   '<u>', '</u>',  '<s>', '</s>',
                   '<blockquote>', '</blockquote>',
                   '<pre>',        '</pre>',
                   '<img src="',   '" />',
                   '</span>',      '</font>',
                   '</a>');
   $string = str_replace($from, $to, $string);
   $string = preg_replace("/\[size=([\d]+)\]/",
      "<span style=\"font-size:$1px\">", $string);
   $string = preg_replace("/\[color=([^\]]+)\]/",
      "<font color='$1'>", $string);
   $string = preg_replace("/\[url\]([^\[]*)<\/a>/",
      "<a href='$1'>$1</a>", $string);
   $string = preg_replace("/\[url=([^\]]*)]/",
      "<a href='$1'>", $string);
   return $string;
}

?>
