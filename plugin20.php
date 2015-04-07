<?php // 插件20：图像的水印

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/
// This example requires a TTF font file named oldenglish.ttf
// to be in the same directory

DOPHP_ImageWatermark("pic.jpg", "wmark.PNG", "PNG", 75,
   "Watermark", "C:/WINDOWS/Fonts/OLDENGL.TTF", 90, "0066ff", 30);

echo "<img src='wmark.PNG'>";

function DOPHP_ImageWatermark($fromfile, $tofile, $type,
   $quality, $text, $font, $size, $fore, $opacity)
{
/*
插件说明
插件20需要一个文件名保存最后生成的GIF文件。此外还需要文本内容，字体以及颜色，大小和阴影等参数。具体是：
$fromfile 源图像文件的路径或文件名。
$tofile 保存最后得到的图像文件的路径或文件名。
$type 图像类型，GIF,JPEG或PNG之一。
$quality 最终生成的图像文件的质量(0表示最差，99表示最好）。
$text 文本内容。
$font 需要用到TureType字体的路径或文件名。
$size 字体的大小。
$fore 十六进制表示的前景颜色（如000000）。
$opacity 水印的透明度（0表示透明，100表示不透明）。
*/

   $contents = file_get_contents($fromfile);
   $image1   = imagecreatefromstring($contents);
   $bound    = imagettfbbox($size, 0, $font, $text);
   $width    = $bound[2] + $bound[0] + 6;
   $height   = abs($bound[1]) + abs($bound[7]) + 5;
   $image2   = imagecreatetruecolor($width, $height);
   $bgcol    = DOPHP_GD_FN1($image2, "fedcba");
   $fgcol    = DOPHP_GD_FN1($image2, $fore);
 
   imagecolortransparent($image2, $bgcol);
   imagefilledrectangle($image2, 0, 0, $width, $height, $bgcol);
   imagettftext($image2, $size, 0, 2, abs($bound[5]) + 2,
      $fgcol, $font, $text);
   imagecopymerge($image1, $image2,
      (imagesx($image1) - $width) / 2,
      (imagesy($image1) - $height) / 2,
      0, 0, $width, $height, $opacity);

   switch($type)
   {
      case "gif":  imagegif($image1,  $tofile); break;
      case "jpeg": imagejpeg($image1, $tofile, $quality); break;
      case "png":  imagepng($image1,  $tofile,
                     round(9 - $quality * .09)); break;
   }
}

function DOPHP_GD_FN1($image, $color)
{
   return imagecolorallocate($image,
      hexdec(substr($color, 0, 2)),
      hexdec(substr($color, 2, 2)),
      hexdec(substr($color, 4, 2)));
}

?>
