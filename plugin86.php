<?php // 插件86：状态信息

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo "It was the ";
echo DOPHP_StatusMessage('best', 'status',
   'The mouse is over the word ‘best’');
echo " of times, it was the ";
echo DOPHP_StatusMessage('worst', 'status',
   'The mouse is over the word ‘worst’');
echo " of times,<br>it was the age of ";
echo DOPHP_StatusMessage('wisdom', 'status',
   'The mouse is over the word ‘wisdom’');
echo " it was the age of ";
echo DOPHP_StatusMessage('foolishness', 'status',
   'The mouse is over the word ‘foolishness’');

echo "<br /><br /><b>Status message</b>: <span id='status'>" .
   "Nothing to report</span>";

function DOPHP_StatusMessage($text, $id, $status)
{
/*
插件说明：
本插件接受三个参数：一段需要定义onMouseOver事件的文本；一个可以插入状态信息的HTML元素的ID;状态信息本身。$text和$status都可以是文本或HTML页面。本插件需要以下参数：
$text:需要显示的文本或HTML页面
$id:<span>或<div>等元素的ID.
$status:状态信息，可以是文本或页面HMTL
*/

   $target = "getElementById('$id').innerHTML";
   return    "<span onMouseOver=\"DOPHP_temp=$target; " .
             "$target='$status';\" onMouseOut=\"$target=" .
             "DOPHP_temp;\">$text</span>";
}

?>
