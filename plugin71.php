<?php // 插件71：建立Google图表

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$title   = 'My Favorite Types of Cheese';
$tcolor  = 'FF0000';
$tsize   = '20';
$type    = 'pie3d';
$width   = '570';
$height  = '230';
$bwidth  = NULL;
$labels  = 'Stilton|Brie|Swiss|Cheddar|Edam|Colby|Gorgonzola';
$legends = $labels;
$colors  = 'BD0000,DE6B00,284B89,008951,9D9D9D,A5AB4B,8C70A4,' .
   'FFD200';
$bgfill  = 'EEEEFF';
$border  = '2';
$bcolor  = '444444';
$data    = '14.9,18.7,7.1,47.3,6.0,3.1,2.1';
$result  = DOPHP_CreateGoogleChart($title, $tcolor, $tsize,
   $type, $bwidth, $labels, $legends, $colors, $bgfill,
   $border, $bcolor, $width, $height, $data);

header('Content-type: image/png');
imagepng($result);

function DOPHP_CreateGoogleChart($title, $tcolor, $tsize,
   $type, $bwidth, $labels, $legends, $colors, $bgfill,
   $border, $bcolor, $width, $height, $data)
{
/*
 * 插件说明：
 * 插件返回一个GD图像，它代表由输入参数生成的一个图表。如果创建失败，则返回FALSE。
 * 它需要以下参数，这些参数（除$width、 $height和$data外）的默认值都为NULL或空字符串
 * $title 图标标题
 * $tcolor 标题颜色
 * $tsize 标题大小
 * $type 图表类型，取以下值之一
 *     -line 折线图
 *     -vbar 柱形图
 *     -hbar 条形图
 *     -gometer google指数图
 *     -pie 饼图（默认）
 *     -pie3d 三维饼图
 *     -venn 维恩图
 *     -radar 雷达图
 * $bwidth 柱形图宽度（只用于柱形图和条形图）
 * $labels 标签，用“|”符号分隔
 * $legends 图例用“|”符号分隔
 * $colors 颜色，有逗号分隔
 * $bgfill 背景颜色（6为十六进制数）
 * $border 边框宽度（以像素为单位）
 * $bcolor 边框颜色（6为十六进制数）
 * $width 图表宽度（以像素为单位）
 * $height 图标高度（一像素为单位）
 * $data 图标数据，以逗号分隔
 */

   $types = array('line'    => 'lc',
                  'vbar'    => 'bvg',
                  'hbar'    => 'bhg',
                  'gometer' => 'gom',
                  'pie'     => 'p',
                  'pie3d'   => 'p3',
                  'venn'    => 'v',
                  'radar'   => 'r');

   if (!isset($types[$type])) $type = 'pie';

   $tail  = "chtt=" . urlencode($title);
   $tail .= "&cht=$types[$type]";
   $tail .= "&chs=$width" . "x" . "$height";
   $tail .= "&chbh=$bwidth";
   $tail .= "&chxt=x,y";
   $tail .= "&chd=t:$data";

   if ($tcolor)
      if ($tsize) $tail .= "&chts=$tcolor,$tsize";
   if ($labels)   $tail .= "&chl=$labels";
   if ($legends)  $tail .= "&chdl=$legends";
   if ($colors)   $tail .= "&chco=$colors";
   if ($bgfill)   $tail .= "&chf=bg,s,$bgfill";

   $url   = "http://chart.apis.google.com/chart?$tail";

   // Uncomment the line below to return a URL to the chart image
   // return $url;
   //var_dump($url);
   $image = imagecreatefrompng($url);

   $w = imagesx($image);
   $h = imagesy($image);
   $image2 = imagecreatetruecolor($w + $border * 2,
      $h + $border * 2);
   $clr = imagecolorallocate($image,
      hexdec(substr($bcolor, 0, 2)),
      hexdec(substr($bcolor, 2, 2)),
      hexdec(substr($bcolor, 4, 2)));
   imagefilledrectangle($image2, 0, 0, $w + $border * 2,
      $h + $border * 2, $clr);
   imagecopy($image2, $image, $border, $border, 0, 0, $w, $h);
   imagedestroy($image);
   return $image2;
}

?>
