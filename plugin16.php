<?php // 插件16：放大图像

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/
// You will need a small jpeg file called icon.jpg in this folder

$image = imagecreatefromjpeg("icon.jpg");

$image1 = DOPHP_ImageResize($image, 500, 300);
imagejpeg($image1, "icon2.jpg");

$image1 = DOPHP_ImageEnlarge($image, 500, 300, 15);
imagejpeg($image1, "icon3.jpg");

echo "<img src='icon.jpg' align='left'>This is a 262 x 182 ";
echo "pixel icon. Below the icon has been enlarged to 500 x ";
echo "300 pixels using the Image Resize plug-in on the left ";
echo "and Image Enlarge on the right. The left image is ";
echo "clearly pixelated while the right one is smoother.";
echo "<br clear='left' /><img src='icon2.jpg' /> ";
echo "<img src='icon3.jpg' />";

function DOPHP_ImageEnlarge($image, $w, $h, $smoothing)
{
/*
插件说明：
插件16接受一个需要放大的GD图像、图像放大后的宽度和高度以及平滑程度。具体如下：
$image 需要放大的GD图像。
$w 新图像的宽度。
$h 新图像的高度。，
$smoothing 平滑程度（"0"为最不平滑，"90"为最平滑）
*/
   
   $oldw  = imagesx($image);
   $oldh  = imagesy($image);
   $step  = 3.1415927 * ((100 - $smoothing) / 100);
   $max   = $w / $step;
   $ratio = $h / $w;
   
   for ($j = $oldw ; $j < $max; $j += $step)
      $image = DOPHP_ImageResize($image, $j * $step,
         $j * $step * $ratio);

   return DOPHP_ImageResize($image, $w, $h);
}

// 调用插件12调整图像大小的函数

function DOPHP_ImageResize($image, $w, $h)
{

   $oldw = imagesx($image);
   $oldh = imagesy($image);
   $temp = imagecreatetruecolor($w, $h);
   imagecopyresampled($temp, $image, 0, 0, 0, 0,
      $w, $h, $oldw, $oldh);
   return $temp;
}

?>
