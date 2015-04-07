<?php // 插件34：检查验证字/验证码

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$salt1   = substr(md5(rand()), 0, 5);
$salt2   = substr(md5(rand()), 0, 5);
$result  = DOPHP_CreateCaptcha(26, rand(4,8), 'tahoma.ttf',
   '', $salt1, $salt2);
$captcha = $result[0];
$token   = $result[1];
$image   = $result[2];

echo "The Captcha is '$captcha', the token is:<br />";
echo "'$token', and the image is in:<br />$image:<br />";
echo "<img src=\"$image\"><br />";
ob_flush(); flush(); sleep(2); // Wait for image to display

$guess = "letmein";
$test  = DOPHP_CheckCaptcha($guess, $token,
   $salt1, $salt2);
if ($test == TRUE) echo "Captcha '$guess' passed<br />";
else echo "Captcha '$guess' failed<br />";

$test = DOPHP_CheckCaptcha($captcha, $token,
   $salt1, $salt2);
if ($test == TRUE) echo "Captcha '$captcha' passed";
else echo "Captcha '$captcha' failed";

function DOPHP_CheckCaptcha($captcha, $token,
   $salt1, $salt2)
{
/*
插件说明：插件将对用户输入的验证字进行验证。这个验证字是由插件33创建的。插件34需要以下参数：
$captcha 用户输入的验证字
$token代表当前验证字的标志
$salt1第一个salt字符串
$salt2第二个salt字符串
*/
   
   return $token == md5("$salt1$captcha$salt2");
}


function DOPHP_CreateCaptcha($size, $length, $font,
   $folder, $salt1, $salt2)
{

   $file    = file_get_contents('dictionary.txt');
   $temps   = explode("\r\n", $file);
   $dict    = array();

   foreach ($temps as $temp)
      if (strlen($temp) == $length)
         $dict[] = $temp;

   $captcha = $dict[rand(0, count($dict) - 1)];
   $token   = md5("$salt1$captcha$salt2");
   $fname   = "$folder" . $token . ".gif";
   DOPHP_GifText($fname, $captcha, $font, $size, "444444",
      "ffffff", $size / 10, "666666");
   $image   = imagecreatefromgif($fname);
   $image   = DOPHP_ImageAlter($image, 2);
   $image   = DOPHP_ImageAlter($image, 13);
   
   for ($j = 0 ; $j < 3 ; ++$j)
      $image = DOPHP_ImageAlter($image, 3);
   for ($j = 0 ; $j < 2 ; ++$j)
      $image = DOPHP_ImageAlter($image, 5);

   imagegif($image, $fname);
   return array($captcha, $token, $fname);
}

function DOPHP_GifText($file, $text, $font, $size, $fore, $back,
   $shadow, $shadowcolor)
{

   $bound  = imagettfbbox($size, 0, $font, $text);
   $width  = $bound[2] + $bound[0] + 6 + $shadow;
   $height = abs($bound[1]) + abs($bound[7]) + 5 + $shadow;
   $image  = imagecreatetruecolor($width, $height);
   $bgcol  = DOPHP_GD_FN1($image, $back);
   $fgcol  = DOPHP_GD_FN1($image, $fore);
   $shcol  = DOPHP_GD_FN1($image, $shadowcolor);
   imagefilledrectangle($image, 0, 0, $width, $height, $bgcol);
   
   if ($shadow > 0) imagettftext($image, $size, 0, $shadow + 2,
      abs($bound[5]) + $shadow + 2, $shcol, $font, $text);
   
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

function DOPHP_ImageAlter($image, $effect)
{

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
