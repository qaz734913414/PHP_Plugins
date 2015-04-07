<?php // 插件100：显示bing地图

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$result = DOPHP_DisplayBingMap(40.68913, -74.0446, 18, 'Aerial', 300, 214);

$text = "<b>The Statue of Liberty</b>, officially titled " .
        "Liberty Enlightening the World, is a monument that " .
        "was presented by the people of France to the United " .
        "States of America in 1886 to celebrate its " .
        "centennial. Standing on Liberty Island in New York " .
        "Harbor, it welcomes visitors, immigrants, and " .
        "returning Americans traveling by ship. The copper-" .
        "clad statue, dedicated on October 28, 1886, " .
        "commemorates the centennial of the signing of the " .
        "United States Declaration of Independence and was " .
        "given to the United States by France to represent " .
        "the friendship between the two countries " .
        "established during the American Revolution.";

echo "<table width='300' height='214' align=left><tr><td>" .
     $result . "</td></tr></table><p align='justify'>$text";

function DOPHP_DisplayBingMap($lat, $long, $zoom, $style, $width, $height)
{
/*
* 显示bing地图
* 插件说明：
* $lat 某个位置的纬度
* $long 某个位置的经度
* $zoom 放大倍数（0表示没放大，19表示最大放大倍数）
* $style 地图的样式，去Road或Aerial之一（Road表示交通图，Aerial表示航拍图，必须与他们一直）
* $width 地图的宽度
* $height 地图的高度
*/

   if ($style != 'Aerial') $style = 'Road';

   $width  .= 'px';
   $height .= 'px';

   $root = 'http://ecn.dev.virtualearth.net/mapcontrol';
   return <<<_END
<script src="$root/mapcontrol.ashx?v=6.2"></script>
<script>
if (window.attachEvent)
{
   window.attachEvent('onload',   Page_Load)
   window.attachEvent('onunload', Page_Unload)
}
else
{
   window.addEventListener('DOMContentLoaded', Page_Load, false)
   window.addEventListener('unload', Page_Unload, false)
}

function Page_Load()
{
   GetMap()
}  

function Page_Unload()
{
   if (map != null)
   {
      map.Dispose()
      map = null
   }
}

function GetMap()
{
   map = new VEMap('DOPHP_DBM')
   map.LoadMap(new VELatLong($lat, $long),
      $zoom, VEMapStyle.$style, false)
}
</script>
<div id='DOPHP_DBM' style="position:relative;
   width:$width; height:$height;"></div>
_END;
}

?>
