<?php // 插件17：图像显示

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/
// You will need an image file called pic.jpg in this folder

DOPHP_ImageDisplay("pic.jpg", "", NULL);

// DOPHP_ImageDisplay("pic.jpg", "gif",  50);
// DOPHP_ImageDisplay("pic.jpg", "png",  50);
// DOPHP_ImageDisplay("pic.jpg", "jpeg", 85);

function DOPHP_ImageDisplay($filename, $type, $quality)
{
/*
插件说明：
插件17输入的参数包括一个图像的文件名、图像类型、显示质量。具体如下：
$filename 字符串，表示一个图像的路径和文件名。
$type 图像文件的类型（GIF\JPEG或PNG).
$quality 表示jpeg或png图像的显示质量（0表示最低质量，99表示最高质量）
*/

   $contents = file_get_contents($filename);
   
   if ($type == "")
   {
      $filetype = getimagesize($filename);
      $mime     = image_type_to_mime_type($filetype[2]);
      header("Content-type: $mime");
      die($contents);
   }

   $image = imagecreatefromstring($contents);
   header("Content-type: image/$type");
   
   switch($type)
   {
      case "gif":  imagegif($image); break;
      case "jpeg": imagejpeg($image, NULL, $quality); break;
      case "png":  imagepng($image,  NULL,
                   round(9 - $quality * .09)); break;
   }
}

?>
