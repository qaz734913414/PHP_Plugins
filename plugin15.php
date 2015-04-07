<?php // 插件15：图像裁剪

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$image = imagecreatefromjpeg("photo.jpg");
$copy =  DOPHP_ImageCrop($image, 100, 10, 120, 150);

if (!$copy) echo "裁剪失败: 超出了边界";
else
{
   imagejpeg($copy, "photo3.jpg");
   echo "<img src='photo.jpg' align=left> ";
   echo "Cropped at 100,10<br />with width*height";
   echo "<br />of 120x150 pixels<br /><br />";
   echo "<img src='photo3.jpg'>";
}

function DOPHP_ImageCrop($image, $x, $y, $w, $h)
{
/*
插件说明：
插件15接受一个图像，从中裁剪一部分图像。此外还需要裁剪对象的相对偏移位置和裁剪图像的大小，如果其中任何一个参数超出边界，则返回FALSE。他需要以下参数：
$image 需要处理的GD图像。
$x 图像的左偏移位置。
$y 图像的顶部偏移位置。
$w 裁剪图像的宽度。
$h 裁剪图像的高度。
*/

   $tw = imagesx($image);
   $th = imagesy($image);

   if ($x > $tw || $y > $th || $w > $tw || $h > $th)
      return FALSE;

   $temp = imagecreatetruecolor($w, $h);
   imagecopyresampled($temp, $image, 0, 0, $x, $y,
      $w, $h, $w, $h);
   return $temp;
}

?>
