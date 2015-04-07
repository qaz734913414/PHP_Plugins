<?php // 插件13：生成缩略图

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$image = imagecreatefromjpeg("test.jpg");
$thumb = DOPHP_MakeThumbnail($image, 100);
imagejpeg($thumb, "thumb.jpg");

$thumb2 = DOPHP_MakeThumbnail($image, 50);
imagejpeg($thumb2, "thumb2.jpg");

echo <<<描述
显示的原图和处理后的缩略图:<br />
<img src='test.jpg' align='left'>&nbsp;<br />
<hr />转换宽度为100像素的缩略图.<br />
&nbsp;<img src='thumb.jpg'><br />
<hr />转换宽度为50像素的缩略图:<br />
<img src='thumb2.jpg'>
描述;

function DOPHP_MakeThumbnail($image, $max)
{
/*
插件说明：
插件13接受两个参数。一个是需要转换为缩略图的图像，另一个是缩略图的最大宽度或高度，据体如下：
$image 一个需要转换的GD图像。
$max 缩略图的最大宽度或高度（取决于那个比较大）
*/
   
   $thumbw = $w = imagesx($image);
   $thumbh = $h = imagesy($image);

   if ($w > $h && $max < $w)
   {
      $thumbh = $max / $w * $h;
      $thumbw = $max;
   }
   elseif ($h > $w && $max < $h)
   {
      $thumbw = $max / $h * $w;
      $thumbh = $max;
   }
   elseif ($max < $w)
   {
      $thumbw = $thumbh = $max;
   }
   return DOPHP_ImageResize($image, $thumbw, $thumbh);
}

// 调用插件12调整图像大小的函数

function DOPHP_ImageResize($image, $w, $h)
{
   $oldw = imagesx($image);
   $oldh = imagesy($image);
   $temp = imagecreatetruecolor($w, $h);
   imagecopyresampled($temp, $image, 0, 0, 0, 0, $w, $h, $oldw, $oldh);
   return $temp;
}

?>