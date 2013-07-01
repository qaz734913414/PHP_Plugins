<?php // 插件12：调整图像大小

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$image = imagecreatefromjpeg("test.jpg");
$newim = DOPHP_ImageResize($image, 500, 300);
imagejpeg($newim, "squashed.jpg");

echo "图片大小已经被调整为500x300像素";
echo "<br /><br /><img src='squashed.jpg'>";

function DOPHP_ImageResize($image, $w, $h)
{
/*
插件说明：
插件12接受一个需要调整大小的图像和新的宽度和高度。具体如下：
$image 需要调整大小的图像，他作为GD库里的一个对象。
$w 新图像的宽度。
$h 新图像的高度。
*/
   
   $oldw = imagesx($image);
   $oldh = imagesy($image);

   $temp = imagecreatetruecolor($w, $h);
   imagecopyresampled($temp, $image, 0, 0, 0, 0,
      $w, $h, $oldw, $oldh);
   return $temp;
}

?>
