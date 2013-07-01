<?php // 插件99：圆角表格

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$contents = "<b>Macbeth Act 5, scene 5, 19-28</b><br />" .
            "<i> Tomorrow, and tomorrow, and tomorrow, " .
            "creeps in this petty pace from day to day, to " .
            "the last syllable of recorded time; and all our " .
            "yesterdays have lighted fools the way to dusty " .
            "death. Out, out, brief candle! Life us but a " .
            "walking shadow, a poor player, that struts and " .
            "frets his hour upon the stage, and then is heard " .
            "no more. It is a tale told by an idiot, full of " .
            "sound and fury, signifying nothing.</i>";

echo DOPHP_RoundedTable('', '', 'dedede', '444444', $contents,
   'corner.php');
   
function DOPHP_RoundedTable($width, $height, $bground,
   $border, $contents, $program)
{
/*
* 圆角表格：
* 插件说明：
* 插件返回HTML代码和角点和边框GIF图像，生成一个圆角表格。
* 它需要一下参数：
* $width 表格的宽度，值为''表示默认值
* $height 表格的高度，值为''表示默认值
* $bground 表格的背景颜色
* $border 表格的边框颜色
* $contents 表格的文本内容或HTML内容
* $program 建立GIF图像程序路径
*/

   if ($width)  $width  = "width='$width'";
   if ($height) $height = "height='$height'";

   $t1 = "<td width='5'><img src='$program?c";
   $t2 = "<td background='$program?c";
   $t3 = "<td width='5' background='$program?c";
   $t4 = "$border&f=$bground' /></td>";
   $t5 = "<td bgcolor='#$bground'>$contents</td>";

   return <<<_END
   <table border='0' cellpadding='0' cellspacing='0'
      $width $height>
   <tr>$t1=tl&b=$t4 $t2=t&b=$t4 $t1=tr&b=$t4</tr>
   <tr>$t3=l&b=$t4 $t5 $t3=r&b=$t4</tr>
   <tr>$t1=bl&b=$t4 $t2=b&b=$t4 $t1=br&b=$t4</tr></table>
_END;
   
}

?>
