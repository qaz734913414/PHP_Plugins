<?php // 插件14：图像修改

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$image = imagecreatefromjpeg("photo.jpg");
$copy = DOPHP_ImageAlter($image, 7);
imagejpeg($copy, "photo2.jpg");

echo "<img src='photo.jpg' align=left><img src='photo2.jpg'>";

function DOPHP_ImageAlter($image, $effect)
{
// 插件说明：
//插件14接受一个需要变换的图像和处理要求，具体是：
//$image 需要变换的GD图像。
//$effect 变换效果，去1~14之间的某个值，如下所示：
//        1 = Sharpen 锐化
//        2 = Blur 模糊
//        3 = Brighten 增亮
//        4 = Darken 变暗
//        5 = Increase Contrast 增加对比度
//        6 = Decrease Contrast 减小对比度
//        7 = Grayscale 灰度值
//        8 = Invert 反转
//        9 = Increase Red 增加红色分量
//       10 = Increase Green 增加绿色分量
//       11 = Increase Blue 增加蓝色分量
//       12 = Edge Detect 边缘检测
//       13 = Emboss 浮雕化
//       14 = Sketchify 素描

   switch($effect)
   {
      case 1:  imageconvolution($image, array(array(-1, -1, -1),
                  array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
               break;
      case 2:  imagefilter($image,
                  IMG_FILTER_GAUSSIAN_BLUR); break;
      case 3:  imagefilter($image,
                  IMG_FILTER_BRIGHTNESS, 20); break;
      case 4:  imagefilter($image,
                  IMG_FILTER_BRIGHTNESS, -20); break;
      case 5:  imagefilter($image,
                  IMG_FILTER_CONTRAST, -20); break;
      case 6:  imagefilter($image,
                  IMG_FILTER_CONTRAST, 20); break;
      case 7:  imagefilter($image,
                  IMG_FILTER_GRAYSCALE); break;
      case 8:  imagefilter($image,
                  IMG_FILTER_NEGATE); break;
      case 9:  imagefilter($image,
                  IMG_FILTER_COLORIZE, 128, 0, 0, 50); break;
      case 10: imagefilter($image,
                  IMG_FILTER_COLORIZE, 0, 128, 0, 50); break;
      case 11: imagefilter($image,
                  IMG_FILTER_COLORIZE, 0, 0, 128, 50); break;
      case 12: imagefilter($image,
                  IMG_FILTER_EDGEDETECT); break;
      case 13: imagefilter($image,
                  IMG_FILTER_EMBOSS); break;
      case 14: imagefilter($image,
                  IMG_FILTER_MEAN_REMOVAL); break;
   }
   
   return $image;
}

?>
