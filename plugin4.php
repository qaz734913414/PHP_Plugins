<?php // 插件4：删除空格

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$text = "      We hold   these truths to be self-evident,       that all men are created equal, that they are endowed by their Creator with certain unalienable     Rights, that among these are Life, Liberty and     the pursuit of Happiness. ?That to secure these rights, \n\n \tGovernments are     instituted among Men, deriving their just powers from the consent of the governed, ?That whenever any      Form of Government becomes destructive \n \t of these ends, it is the    Right of the People to alter or to abolish it, and to institute new Government, laying its foundation on such principles and      organizing its powers in such form, as to them shall seem most likely to effect their Safety and Happiness.    ";

echo "<textarea cols='68' rows='11'>$text</textarea><br />";
echo DOPHP_StripWhitespace($text);

function DOPHP_StripWhitespace($text)
{
   /*
   插件说明
   这个插件接受一个包包含任何文本的字符串参数，将去掉全部多余空格。它需要一个参数：
   $text——字符串变量，包含需要处理的文本。
   */
 
   return preg_replace('/\s+/', ' ', $text);
}

?>