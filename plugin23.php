<?php // 插件23：检查链接地址

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$page   = "http://shuimu.js.cn";
echo      "Checking $page<br />\n"; ob_flush(); flush();
$result = DOPHP_CheckLinks($page, 2, 180);

if ($result[0] > 0)
{
   echo "<br />$result[0] failed URLs:<br /><ul>\n";
   
   for ($j = 0 ; $j < $result[0] ; ++$j)
      echo "<li><a href='" . $result[1][$j] .
         "'>" . $result[1][$j] . "</a></li>\n";
}
else echo "<br />All URLs successfully accessed.";

function DOPHP_CheckLinks($page, $timeout, $runtime)
{
/*
插件说明：
本插件接受一个web页面的URL地址（自己的或第三方的）,检查这个页面里所有全部链接并进行测试，看看他们是否都链接到有效地页面。他需要以下参数：
$page web页面的URL地址，包括“http://"前导符和域名。
$timeout 在认为某个页面不可用之前必须等待的时间（单位为s）。
$runtime 在超时之前这个脚本必须运行的时间。
*/

   ini_set('max_execution_time', $runtime);
   $contents = @file_get_contents($page);
   if (!$contents) return array(1, array($page));
   
   $checked = array();
   $failed  = array();
   $fail    = 0;
   $urls    = DOPHP_GetLinksFromURL($page);
   $context = stream_context_create(array('http' =>
      array('timeout' => $timeout))); 
      
   for ($j = 0 ; $j < count($urls); $j++)
   {
      if (!in_array($urls[$j], $checked))
      {
         $checked[] = $urls[$j];

         // Uncomment the following line to view progress
         // echo " $urls[$j]<br />\n"; ob_flush(); flush();

         if (!@file_get_contents($urls[$j], 0, $context, 0, 256))
            $failed[$fail++] = $urls[$j];
      }
   }

   return array($fail, $failed);
}


function DOPHP_GetLinksFromURL($page)
{

   $contents = @file_get_contents($page);
   if (!$contents) return NULL;
   
   $urls    = array();
   $dom     = new domdocument();
   @$dom    ->loadhtml($contents);
   $xpath   = new domxpath($dom);
   $hrefs   = $xpath->evaluate("/html/body//a");

   for ($j = 0 ; $j < $hrefs->length ; $j++)
      $urls[$j] = DOPHP_RelToAbsURL($page,
         $hrefs->item($j)->getAttribute('href'));

   return $urls;
}

function DOPHP_RelToAbsURL($page, $url)
{

   if (substr($page, 0, 7) != "http://") return $url;
   
   $parse = parse_url($page);
   $root  = $parse['scheme'] . "://" . $parse['host'];
   $p     = strrpos(substr($page, 7), '/');
   
   if ($p) $base = substr($page, 0, $p + 8);
   else $base = "$page/";
   
   if (substr($url, 0, 1) == '/')           $url = $root . $url;
   elseif (substr($url, 0, 7) != "http://") $url = $base . $url;
   
   return $url;
}

?>
