<?php // 插件27：插入优酷视频

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo DOPHP_EmbedYouTubeVideo("VjnygQ02aW4", 370, 300, 1, 1, 0);

function DOPHP_EmbedYouTubeVideo($id, $width, $height, $hq,
   $full, $auto)
{
/*
插件说明：
$id YouTube视频ID,如VjnygQ02aW4
$width 显示宽度
$height 显示高度
$hq 如设置为1，选择高质量播放模式（假设视频是高质量的）。
$full 如设置为1，允许视频在全屏模式下播放
$auto 如设置为1，当页面装载后，视频自动播放
*/
   if ($hq) $q = "&ap=%2526fmt%3D18";
   else $q = "";

   return <<<_END
<object width="$width" height="$height">
<param name="movie"
   value="http://www.youtube.com/v/$id&fs=1&autoplay=$auto$q">
</param>
<param name="allowFullScreen" value="$full"></param>
<param name="allowscriptaccess" value="always"></param>
<embed src="http://www.youtube.com/v/$id&fs=1&autoplay=$auto$q"
   type="application/x-shockwave-flash"
   allowscriptaccess="always" allowfullscreen="$full"
   width="$width" height="$height"></embed></object>
_END;
}

?>
