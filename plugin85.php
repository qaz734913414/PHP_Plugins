<?php // 插件85：切换文本内容

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text1 = " Photosynthesis is a process that converts carbon ".
         "dioxide into organic compounds, especially sugars, " .
         "using the energy from sunlight.";
$link1 = "Choose long definition";
$text2 = "$text1 Photosynthesis occurs in plants, algae, and " .
         "many species of Bacteria, but not in Archaea. Photo" .
         "synthetic organisms are called photoautotrophs, " .
         "since it allows them to create their own food. In " .
         "plants, algae and cyanobacteria photosynthesis uses " .
         "carbon dioxide and water, releasing oxygen as a " .
         "waste product. Photosynthesis is vital for life on " .
         "Earth. As well as maintaining the normal level of " .
         "oxygen in the atmosphere, nearly all life either " .
         "depends on it directly as a source of energy, or " .
         "indirectly as the ultimate source of the energy in " .
         "their food.";
$link2 = "Choose short definition";

echo "<h2>Robin's gardening website</h2>";
echo "<h3>The sun and photosynthesis</h3>";

echo DOPHP_ToggleText($text1, $link1, $text2, $link2);

echo "<h3>Pollination</h3>";
echo "...etc...";

function DOPHP_ToggleText($text1, $link1, $text2, $link2)
{
/*
插件说明：
当鼠标单击超链接时，插件在两组文本(或HTML)之间进行切换。他需要以下参数：
$text1:显示的页面主文本。
$link1 显示在页面的主超链接文本。
$text2 另一个文本。
$link2 另一个超链接文本
*/
   $tok = rand(0, 1000000);
   $out   = "<div id='DOPHP_TT1_$tok' style='display:block;'>" .
            "<a href=\"javascript://\" onClick=\"document." .
            "getElementById('DOPHP_TT1_$tok').style.display=" .
            "'none'; document.getElementById('DOPHP_TT2_$tok')" .
            ".style.display='block';\">$link1</a>$text1</div>\n";

   $out  .= "<div id='DOPHP_TT2_$tok' style='display:none;'>" .
            "<a href=\"javascript://\" onClick=\"document." .
            "getElementById('DOPHP_TT1_$tok').style.display=" .
            "'block'; document.getElementById('DOPHP_TT2_$tok')" .
            ".style.display='none';\">$link2</a>$text2</div>\n";
   return  $out;
}

?>
