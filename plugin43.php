<?php // 插件43：可以自动返回的链接

$logfile = "refererlog";
echo "Referring URLs in logfile '$logfile':<br /><br />";

$results = DOPHP_AutoBackLinks($logfile);
if (!$results[0]) echo "No referring URLs";
else foreach ($results[1] as $result)
{
   $title = DOPHP_GetTitleFromURL($result);
   echo "<a href='$result'>";
   echo $title ? $title : $result;
   echo "</a><br />";
}

function DOPHP_AutoBackLinks($filename)
{
/*
插件说明：
本插件接受一个文件名，他保存了所有链接到当前网页的网站的详细信息。这个文件名由插件30的DOPHP_RefererLog()函数创建的。
本插件需要以下参数
$filename 文件名或路径
*/
   if (!file_exists($filename)) return array(FALSE);
   
   $inbound = array();
   $logfile = file_get_contents($filename);
   $links   = explode("\n", rtrim($logfile));
   $links   = array_count_values($links);
   arsort($links, SORT_NUMERIC);
   
   foreach ($links as $key => $val)
      if ($key != " No Referer")
         $inbound[] = $key;

   return array(TRUE, $inbound);
}


function DOPHP_GetTitleFromURL($page)
{

   $contents = @file_get_contents($page);
   if (!$contents) return FALSE;
   
   preg_match("/<title>(.*)<\/title>/i", $contents, $matches);

   if (count($matches)) return $matches[1];
   else return FALSE;
}

?>
