<?php // 插件19：GIF文本

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/
// This example requires a TTF font file C:/WINDOWS/Fonts/OLDENGL.TTF
// to be in the same directory

DOPHP_GifText("font1.gif", "Old English Font", "C:/WINDOWS/Fonts/OLDENGL.TTF",
   26, "ff0000", "ffffff", 1, "444444");
DOPHP_GifText("font2.gif", "Old English Font", "C:/WINDOWS/Fonts/OLDENGL.TTF",
   36, "ff0000", "ffffff", 2, "444444");
DOPHP_GifText("font3.gif", "Old English Font", "C:/WINDOWS/Fonts/OLDENGL.TTF",
   46, "ff0000", "ffffff", 3, "444444");
DOPHP_GifText("font4.gif", "Old English Font", "C:/WINDOWS/Fonts/OLDENGL.TTF",
   56, "ff0000", "ffffff", 4, "444444");

echo "<img src='font1.gif'>";
echo "<img src='font2.gif'>";
echo "<img src='font3.gif'>";
echo "<img src='font4.gif'>";

function DOPHP_GifText($file, $text, $font, $size, $fore, $back,
   $shadow, $shadowcolor)
{
/*
插件说明：
本插件需要一个用来保存GIF图像的文件名，一个文本和文本的字体，颜色，字体大小以及阴影等详细信息。具体如下：
$file GIF图像的保存路径和文件名。
$text 需要处理的文本。
$font TrueType字体的路径和文件名。
$size 字体大小。
$fore 前景颜色，用十六进制表示（如000000）。
$back 背景颜色，用十六进制表示（如FFFFFF)。
$shadow 用像素个数表示文字的阴影效果（0表示无阴影）。
$shadowcolor 阴影颜色（如444444）。
*/
   $bound  = imagettfbbox($size, 0, $font, $text);
   $width  = $bound[2] + $bound[0] + 6 + $shadow;
   $height = abs($bound[1]) + abs($bound[7]) + 5 + $shadow;
   $image  = imagecreatetruecolor($width, $height);
   $bgcol  = DOPHP_GD_FN1($image, $back);
   $fgcol  = DOPHP_GD_FN1($image, $fore);
   $shcol  = DOPHP_GD_FN1($image, $shadowcolor);
   imagefilledrectangle($image, 0, 0, $width, $height, $bgcol);
   
   if ($shadow > 0)
   {
      imagettftext($image, $size, 0, $shadow + 2,
      abs($bound[5]) + $shadow + 2, $shcol, $font, $text);
   
      for ($j = 0 ; $j < 5 ; ++$j)
         imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
   }
   
   imagettftext($image, $size, 0, 2, abs($bound[5]) + 2, $fgcol,
      $font, $text);
   imagegif($image, $file);
}

function DOPHP_GD_FN1($image, $color)
{
   return imagecolorallocate($image,
      hexdec(substr($color, 0, 2)),
      hexdec(substr($color, 2, 2)),
      hexdec(substr($color, 4, 2)));
}

?>
