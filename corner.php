<?php // Plug-in 98: Corner Gif

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
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
   // Plug-in 98: Corner Gif

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
