<?php // 插件28：创建列表

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$fruits   = array("Apple", "Pear", "Banana", "Plum", "Orange");
$bullets1 = array("1", "A", "a", "I", "i");
$bullets2 = array("disc", "square", "circle");

echo "<table border='0' width='100%'><tr>";

for ($j = 0 ; $j < 5 ; ++$j)
   echo"<td>" . DOPHP_CreateList($fruits, 1, "ol", $bullets1[$j]) . "</td>\n";

echo "</tr><tr>";

for ($j = 0 ; $j < 3 ; ++$j)
   echo"<td>" . DOPHP_CreateList($fruits, 1, "ul", $bullets2[$j]) . "</td>\n";

echo "<td colspan='2'></td></tr></table>";

function DOPHP_CreateList($items, $start, $type, $bullet)
{
/*
插件说明：
本插件需要输入一个数组和列表的格式控制参数。这个数组包含了一个列表的全部列表项，他需要以下参数：
$item 数组，它包含一个列表的全部列表项
$start 有序列表的起始编号
$type 列表的类型，ul表示无序列表，ol表示有序了表。
$bullet 项目符号或列表编号的类型。对于无序列表，有正方形、圆形和圆盘形。
对于有序列表，又l,A,a,I或i
*/
   $list = "<$type start='$start' type='$bullet'>";
   foreach ($items as $item) $list .= "<li>$item</li>";
   return $list . "</$type>";
}

?>
