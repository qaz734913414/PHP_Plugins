<?php // 插件72：用Curl获取网页内容

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-GB; ' .
         'rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR ' .
         '3.5.30729)';
$url   = 'http://shuimu.js.cn';

echo DOPHP_CurlGetContents($url, $agent);

function DOPHP_CurlGetContents($url, $agent)
{
/*
 * 插件说明：
 * 设计插件的目的是当需要读取网页内容时，可以用本插件取代file_get_contents()函数。
 * 它接受网页的URL地址和准备模仿的浏览器用户代理字符串。若调用成功，
 * 返回这个网页的内容，若调用失败，返回FALSE。它需要以下参数：
 * $url 网页的URL地址
 * $agent 浏览器的用户代理字符串。
 */

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,            $url);
   curl_setopt($ch, CURLOPT_USERAGENT,      $agent);
   curl_setopt($ch, CURLOPT_HEADER,         0);
   curl_setopt($ch, CURLOPT_ENCODING,       "gzip");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   curl_setopt($ch, CURLOPT_FAILONERROR,    1);
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
   curl_setopt($ch, CURLOPT_TIMEOUT,        8);
   $result = curl_exec($ch);
   curl_close($ch);
   return $result;
}

?>
