<?php // 插件18：图像转换

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

DOPHP_ImageConvert("photo.jpg", "photo4.png", "png", 0);

list($width, $height, $type, $attr)=getimagesize("photo.jpg");
print_r (getimagesize("photo.jpg"));
echo "<hr>";
$imagesize = round(filesize("photo.jpg")/1024)."Kb";
echo $imagesize." Size of a jpeg converted to another jpeg of ";
echo $imagesize*0.8."kb original) at a quality setting of 25...<br />";
echo "<img src='photo.jpg' align='left'> <img src='photo4.png'>";

function DOPHP_ImageConvert($fromfile, $tofile, $type, $quality)
{
/*
插件说明：
插件18需要输入一个图像文件名、转换后要保存的文件名以及图像质量。具体如下：
$fromfile 字符串，表示图像文件的路径和文件名。
$tofile 字符串，表示新图像保存的路径和文件名。
$type 图像文件的类型（如GIF,JPEG或PNG).
$quality 表示JPEG或PNG图像的质量(0表示最低质量，99表示最高质量）
*/

   $contents = file_get_contents($fromfile);
   $image    = imagecreatefromstring($contents);

   switch($type)
   {
      case "gif":  imagegif($image,  $tofile); break;
      case "jpeg": imagejpeg($image, $tofile, $quality); break;
      case "png":  imagepng($image,  $tofile,
                   round(9 - $quality * .09)); break;
   }
}

?>
