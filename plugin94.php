<?php // 插件94：获取Amazon网站图书销售排行榜

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$isbn   = '007149216X';
$result = DOPHP_GetBookFromISBN($isbn);
if (!$result) echo "Could not find title for ISBN '$isbn'.";
else
{
   echo "<img src='$result[1]' align='left'><b>$result[0]<br>" .
        "Amazon.com Sales Rank: ";
   echo DOPHP_GetAmazonSalesRank($isbn, 'amazon.com');
}

function DOPHP_GetAmazonSalesRank($isbn, $site)
{
/*
* 获取Amazon网站图书销售排行榜
* 插件说明：
* 插件接受一个ISBN号码和一个Amazon网站的域名，返回该图书在该网站的销售等级。
* 若操作成功，则返回一个数值表示该书的受欢迎程度，其中1表示最受欢迎。
* 若操作失败，如找不到此书，或者他还没有等级，则返回FALSE。
* 它需要以下参数：
* $ISBN 10位ISBN号码
* $site 一个Amazon网站的域名。
* 它取amazon.com, amazon.ca, amazon.co.uk, amazon.fr, zmazon.de和zmazon.co.jp这六个值之一
*/
   
   $url = "http://www.$site/gp/aw/d.html?pd=1" .
          "&l=Product%20Details&a=$isbn";
   $end = '<br />';

   switch(strtolower($site))
   {
      case 'amazon.com':
      case 'amazon.ca':
      case 'amazon.co.uk':
         $find = 'Sales Rank: ';
         break;
      case 'amazon.fr':
         $find = 'ventes Amazon.fr: ';
         break;
      case 'amazon.de':
         $find = 'Verkaufsrang: ';
         break;
      case 'amazon.co.jp':
         $find = '<li id="SalesRank">';
         $url  = "http://$site/gp/product/$isbn";
         $end  = '(<a';
         break;
   }

   $page = file_get_contents($url);
   if (!strlen($page)) return FALSE;

   $ptr1 = strpos($page, $find);
   if (!$ptr1) return FALSE;

   $ptr2 = strpos($page, $end, $ptr1);
   $temp = substr($page, $ptr1, $ptr2 - $ptr1);
   return trim(preg_replace('/[^\d]/', '', $temp));
}


function DOPHP_GetBookFromISBN($isbn)
{

   $find = '<meta name="description" content="Amazon:';
   $url  = "http://www.amazon.com/gp/aw/d.html?a=$isbn";
   $img  = 'http://ecx.images-amazon.com/images/I';

   $page = @file_get_contents($url);
   if (!strlen($page)) return array(FALSE);

   $ptr1 = strpos($page, $find) + strlen($find);
   if (!$ptr1) return array(FALSE);

   $ptr2  = strpos($page, '" />', $ptr1);
   $title = substr($page, $ptr1, $ptr2 - $ptr1);

   $find = $img;
   $ptr1  = strpos($page, $find) + strlen($find);
   $ptr2  = strpos($page, '"', $ptr1);
   $image = substr($page, $ptr1, $ptr2 - $ptr1);

   return array($title, $img . $image);
}

?>
