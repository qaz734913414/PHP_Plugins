<?php // 插件87：幻灯片显示

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$account = 'robinfnixon';
$result  = DOPHP_FetchFlickrStream($account);

if (!$result[0]) echo "No images returned";
else
{
   $style = "'position:absolute; top:10px; left:10px'";
   echo "<img id='DOPHP_SS1' style=$style>";
   echo "<img id='DOPHP_SS2' style=$style>";
   echo DOPHP_SlideShow($result[1]);
}

function DOPHP_SlideShow($images)
{
/*
插件说明：
插件接受一组图像的URL地址，返回一段Javascript代码，实现图像的幻灯片式显示。他需要以下参数：
$images：一组图像的URL地址。
*/

   $count = count($images);
   $out   = "<script>images = new Array($count);\n";

   for ($j=0 ; $j < $count ; ++$j)
   {
      $out .= "images[$j] = new Image();";
      $out .= "images[$j].src = '$images[$j]'\n";
   }

   $out .= <<<_END
counter = 0
step    = 4
fade    = 100
delay   = 0
pause   = 250
startup = pause

load('DOPHP_SS1', images[0]);
load('DOPHP_SS2', images[0]);
setInterval('process()', 20);

function process()
{
   if (startup-- > 0) return;

   if (fade == 100)
   {
      if (delay < pause)
      {
         if (delay == 0)
         {
            fade = 0;
            load('DOPHP_SS1', images[counter]);
            opacity('DOPHP_SS1', 100);
            ++counter;

            if (counter == $count) counter = 0;

            load('DOPHP_SS2', images[counter]);
            opacity('DOPHP_SS2', 0);
         }
         ++delay;
      }
      else delay = 0;
   }
   else
   {
      fade += step;
      opacity('DOPHP_SS1', 100 - fade);
      opacity('DOPHP_SS2', fade);
   }
}

function opacity(id, deg)
{
    var object          = $(id).style;
    object.opacity      = (deg/100);
    object.MozOpacity   = (deg/100);
    object.KhtmlOpacity = (deg/100);
    object.filter       = "alpha(opacity = " + deg + ")";
}

function load(id, img)
{
   $(id).src = img.src;
}

function $(id)
{
   return document.getElementById(id)
}

</script>
_END;

   return $out;
}


function DOPHP_FetchFlickrStream($account)
{
   // Plug-in 74: Fetch Flickr Stream

   $url  = 'http://flickr.com/photos';
   $page = @file_get_contents("$url/$account/");
   if (!$page) return array(FALSE);

   $pics = array();
   $rss  = strstr($page, 'rss+xml');
   $rss  = strstr($rss, 'http://');
   $rss  = substr($rss, 0, strpos($rss, '"'));
   $xml  = file_get_contents($rss);
   $sxml = simplexml_load_string($xml);

   foreach($sxml->entry as $item)
   {
      for ($j=0 ; $j < sizeof($item->link) ; ++$j)
      {
         if (strstr($item->link[$j]['type'], 'image'))
         {
            $t=str_replace('_m', '', $item->link[$j]['href']);
            $t=str_replace('_t', '', $t);
            $pics[]=$t;
         }
      }
   }
   
   return array(count($pics), $pics);
}

?>
