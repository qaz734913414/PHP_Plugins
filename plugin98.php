<?php // 插件98：圆角表格GIF图像

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$corner  = $_GET['c'];
$border  = $_GET['b'];
$bground = $_GET['f'];

$result = DOPHP_CornerGif($corner, $border, $bground);
if ($result)
{
   header('Content-type: image/gif');
   imagegif($result);
}

function DOPHP_CornerGif($corner, $border, $bground)
{
/*
* 圆角表格GIF图像
* 插件说明：
* 插件用于创建圆角表格所需要的角和边GIF图像。
* 若创建成功一个GD图像，它代表生成的GIF图像。
* 若创建失败，则返回一个未知量或一个位置图像。
* 它需要以下参数：
* $corner 创建图像的标识符，取tl、t、tr、l、r、bl、b、和br值之一，分别表示左上角，顶边框，右上角，左边框，右边框，左下角，右下角
* $border 边框的颜色，用六位十六进制表示
* $bground 北京颜色，有六位十六位进制表示
*/

   $data  = array(array(0, 0, 0, 0, 0),
                  array(0, 0, 0, 1, 1),
                  array(0, 0, 1, 2, 2),
                  array(0, 1, 2, 2, 2),
                  array(0, 1, 2, 2, 2));

   $image = imagecreatetruecolor(5, 5);
   $bcol  = DOPHP_GD_FN1($image, $border);
   $fcol  = DOPHP_GD_FN1($image, $bground);
   $tcol  = DOPHP_GD_FN1($image, 'ffffff');

   imagecolortransparent($image, $tcol);
   imagefill($image, 0 , 0, $tcol);

   if (strlen($corner) == 2)
   {
      for ($j = 0 ; $j < 5 ; ++$j)
      {
         for ($k = 0 ; $k < 5 ; ++ $k)
         {
            switch($data[$j][$k])
            {
               case 1:
                  imagesetpixel($image, $j, $k, $bcol); break;
               case 2:
                  imagesetpixel($image, $j, $k, $fcol); break;
            }
         }
      }
   }
   else
   {
      imagefilledrectangle($image, 0, 0, 4, 0, $bcol);
      imagefilledrectangle($image, 0, 1, 4, 4, $fcol);
   }

   switch($corner)
   {
      case 'tr': case 'r':
         $image = imagerotate($image, 270, $tcol); break;
      case 'br': case 'b':
         $image = imagerotate($image, 180, $tcol); break;
      case 'bl': case 'l':
         $image = imagerotate($image,  90, $tcol); break;
   }
   
   return $image;
}

function DOPHP_GD_FN1($image, $color)
{
   return imagecolorallocate($image,
      hexdec(substr($color, 0, 2)),
      hexdec(substr($color, 2, 2)),
      hexdec(substr($color, 4, 2)));
}

?>
