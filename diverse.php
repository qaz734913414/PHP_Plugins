<?php // diverse.php

// Plug-in PHP: Diverse Plug-ins (91 - 100)

function DOPHP_GetCountryFromIP($ip)
{
   // Plug-in 91: Get Country From IP
   //
   // This plug-in returns the country associated with a
   // supplied IP number. It requires this argument:
   //
   //    $ip: An IP address

   $iptemp = explode('.', $ip);
   $ipdec  = $iptemp[0] * 256 * 256 * 256 +
             $iptemp[1] * 256 * 256 +
             $iptemp[2] * 256 +
             $iptemp[3];
   $file  = file_get_contents('ips.txt');
   if (!strlen($file)) return FALSE;

   $lines = explode("\n", $file);

   foreach($lines as $line)
   {
      if (strlen($line))
      {
         $parts = explode(',', trim($line));

         if ($ipdec >= $parts[0] && $ipdec <= $parts[1])
            return $parts[2];
      }
   }

   return FALSE;
}

function DOPHP_CaptchaBypass()
{
   // Plug-in 92: Captcha Bypass
   //
   // This plug-in checks whether it looks like a real person
   // is using your website and returns TRUE if so, otherwise
   // it returns FALSE. It requires no arguments

   if (isset($_SERVER['HTTP_REFERER']) &&
       isset($_SERVER['HTTP_USER_AGENT']))
         return TRUE;
   return FALSE;
}

function DOPHP_GetBookFromISBN($isbn)
{
   // Plug-in 93: Get Book From ISBN
   //
   // This plug-in looks up an ISBN-10 at Amazon.com and then
   // returns the matching book title and a thumbnail image
   // of the front cover. It requires this argument:
   //
   //    $isbn: The ISBN to look up
   //
   // Updated from the function in the book to take into
   // account changes to the Amazon HTML.

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

function DOPHP_GetAmazonSalesRank($isbn, $site)
{
   // Plug-in 94: Get Amazon Sales Rank
   //
   // This plug-in looks up an ISBN-10 at the chosen Amazon
   // website and returns the book's Sales Rank at that site.
   // It requires these arguments:
   //
   //    $isbn: The ISBN to look up
   //    $site: The Amazon website to use, out of:
   //           amazon.com, amazon.ca, amazon.co.uk, amazon.fr,
   //           amazon.de and amazon.co.jp
   
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

function DOPHP_PatternMatchWord($word, $dictionary)
{
   // Plug-in 95: Pattern Match Word
   //
   // This plug-in searches a dictionary of words for all those
   // matching a given pattern. Upon success it retuns a two
   // element array, the first of which is is the number of
   // matches and the second is an array containing the
   // matches. On failure it returns a single element array
   // with the value FALSE. It requires these arguments:
   //
   //    $word:       A word to look up
   //    $dictionary: The location of a list of words separated
   //                 by non-word or space characters such as
   //                 \n or \r\n

   $dict = @file_get_contents($dictionary);
   if (!strlen($dict)) return array(FALSE);
   $word = preg_replace('/[^a-z\.]/', ''. strtolower($word));
   preg_match_all('/\b' . $word . '\b/', $dict, $matches);
   return array(count($matches[0]), $matches[0]);
}

function DOPHP_SuggestSpelling($word, $dictionary)
{
   // Plug-in 96: Suggest Spelling
   //
   // This plug-in should be supplied with a misspelled word
   // using which it will search $dictionary for words it
   // believes the user may have meant to have typed in. Upon
   // success it returns a two element array, the first of
   // which is the number of possible words it suggests, and
   // the second is an array of words in order of likelihood.
   // On failure a single element array with the value FALSE
   // is returned. It requires these arguments:
   //
   //    $word:       A word to look up
   //    $dictionary: The location of a list of words separated
   //                 by non-word or space characters such as
   //                 \n or \r\n

   if (!strlen($word)) return array(FALSE);

   static $count, $words;

   if ($count++ == 0)
   {
      $dict = @file_get_contents($dictionary);
      if (!strlen($dict)) return array(FALSE);
      $words = explode("\r\n", $dict);
   }

   $possibles = array();
   $known     = array();
   $suggested = array();
   $wordlen   = strlen($word);
   $chars     = str_split('abcdefghijklmnopqrstuvwxyz');

   for($j = 0 ; $j < $wordlen ; ++$j)
   {
      $possibles[] =    substr($word, 0, $j) .
                        substr($word, $j + 1);

      foreach($chars as $letter)
         $possibles[] = substr($word, 0, $j) .
                        $letter .
                        substr($word, $j + 1);
   }

   for($j = 0; $j < $wordlen - 1 ; ++$j)
      $possibles[] =    substr($word, 0, $j) .
                        $word[$j + 1] .
                        $word[$j] .
                        substr($word, $j +2 );

   for($j = 0; $j < $wordlen + 1 ; ++$j)
      foreach($chars as $letter)
         $possibles[] = substr($word, 0, $j).
                        $letter.
                        substr($word, $j);

   $known = array_intersect($possibles, $words);
   $known = array_count_values($known);
   arsort($known, SORT_NUMERIC);

   foreach ($known as $temp => $val)
      $suggested[] = $temp;

   return array(count($suggested), $suggested);
}

function DOPHP_GoogleTranslate($text, $lang1, $lang2)
{
   // Plug-in 97: Google Translate
   //
   // This plug-in uses Google Translate to translate text from
   // one language to another. Upon success it returns the
   // translation using UTF-8 to enable accented and other
   // characters. On failure it returns FALSE. It requires these
   // arguments:
   //
   //    $text:  Text to translate
   //    $lang1: The source language
   //    $lang2: The destination language
   //
   // $lang1 and $lang2 must each be one of: Arabic, Bulgarian,
   // Simplified Chinese, Traditional Chinese, Croatian, Czech,
   // Danish, Dutch, English, Finnish, French, German, Greek,
   // Hindi, Italian, Japanese, Korean, Polish, Portuguese,
   // Romanian, Russian, Spanish or Swedish.

   $langs = array(
      'arabic'              => 'ar',
      'bulgarian'           => 'bg',
      'simplified chinese'  => 'zh-cn',
      'traditional chinese' => 'zh-tw',
      'croatian'            => 'hr',
      'czech'               => 'cs',
      'danish'              => 'da',
      'dutch'               => 'nl',
      'english'             => 'en',
      'finnish'             => 'fi',
      'french'              => 'fr',
      'german'              => 'de',
      'greek'               => 'el',
      'hindi'               => 'hi',
      'italian'             => 'it',
      'japanese'            => 'ja',
      'korean'              => 'ko',
      'polish'              => 'pl',
      'portuguese'          => 'pt',
      'romanian'            => 'ro',
      'russian'             => 'ru',
      'spanish'             => 'es',
      'swedish'             => 'sv');

   $lang1 = strtolower($lang1);
   $lang2 = strtolower($lang2);
   $root  = 'http://ajax.googleapis.com/ajax/services';
   $url   = $root . '/language/translate?v=1.0&q=';
   
   if (!isset($langs[$lang1]) || !isset($langs[$lang1]))
      return FALSE;

   $json = @file_get_contents($url . urlencode($text) .
           '&langpair='. $langs[$lang1] . '%7C' .
           $langs[$lang2]);

   if (!strlen($json)) return FALSE;
   
   $result = json_decode($json);
   return $result->responseData->translatedText;
 }

function DOPHP_CornerGif($corner, $border, $bground)
{
   // Plug-in 98: Corner Gif
   //
   // This plug-in creates a gif image suitable for building
   // rounded table edges. On success it returns a GD image.
   // On failure it returns FALSE. It requires these
   // arguments:
   //
   //    $corner:  The corner type (which includes edges) out
   //              of tl, t, tr, l, r, bl, b and br for top-
   //              left, top, top-right, left, right, bottom-
   //              left, bottom and bottom-right
   //    $border:  The border color as six hexadecimal digits
   //    $bground: The fill color as six hexadecimal digits

   $data  = array(array(0, 0, 0, 0, 0),
                  array(0, 0, 0, 1, 1),
                  array(0, 0, 1, 2, 2),
                  array(0, 1, 2, 2, 2),
                  array(0, 1, 2, 2, 2));

   $image = imagecreatetruecolor(5, 5);
   $bcol  = DOPHP_GD_FN1($image, $border);
   $fcol  = DOPHP_GD_FN1($image, $bground);
   $tcol  = DOPHP_GD_FN1($image, 'ffffff');

   imagecolortransparent($image, $tcol);
   imagefill($image, 0 , 0, $tcol);

   if (strlen($corner) == 2)
   {
      for ($j = 0 ; $j < 5 ; ++$j)
      {
         for ($k = 0 ; $k < 5 ; ++ $k)
         {
            switch($data[$j][$k])
            {
               case 1:
                  imagesetpixel($image, $j, $k, $bcol); break;
               case 2:
                  imagesetpixel($image, $j, $k, $fcol); break;
            }
         }
      }
   }
   else
   {
      imagefilledrectangle($image, 0, 0, 4, 0, $bcol);
      imagefilledrectangle($image, 0, 1, 4, 4, $fcol);
   }

   switch($corner)
   {
      case 'tr': case 'r':
         $image = imagerotate($image, 270, $tcol); break;
      case 'br': case 'b':
         $image = imagerotate($image, 180, $tcol); break;
      case 'bl': case 'l':
         $image = imagerotate($image,  90, $tcol); break;
   }
   
   return $image;
}

function DOPHP_RoundedTable($width, $height, $bground,
   $border, $contents, $program)
{
   // Plug-in 99: Rounded Table
   //
   // This plug-in takes the contents of $contents and places it
   // inside a table to which it gives rounded borders. It
   // requires these arguments:
   //
   //    $width:    Width of table (optional), to leave at
   //               default set to "" or NULL
   //    $height:   Height of table (optional), to leave at
   //               default set to "" or NULL
   //    $bground:  Background fill color of table
   //    $border:   Border color of table
   //    $contents: Table contents (may include HTML)
   //    $program:  Location of the corner.php program

   if ($width)  $width  = "width='$width'";
   if ($height) $height = "height='$height'";

   $t1 = "<td width='5'><img src='$program?c";
   $t2 = "<td background='$program?c";
   $t3 = "<td width='5' background='$program?c";
   $t4 = "$border&f=$bground' /></td>";
   $t5 = "<td bgcolor='#$bground'>$contents</td>";

   return <<<_END
   <table border='0' cellpadding='0' cellspacing='0'
      $width $height>
   <tr>$t1=tl&b=$t4 $t2=t&b=$t4 $t1=tr&b=$t4</tr>
   <tr>$t3=l&b=$t4 $t5 $t3=r&b=$t4</tr>
   <tr>$t1=bl&b=$t4 $t2=b&b=$t4 $t1=br&b=$t4</tr></table>
_END;
   
}

function DOPHP_DisplayBingMap($lat, $long, $zoom, $style,
   $width, $height)
{
   // Plug-in 100: Display Bing Map
   //
   // This plug-in takes the contents of $contents and places it
   // inside a table to which it gives rounded borders. It
   // requires these arguments:
   //
   //    $lat:    Latitude of the location to display
   //    $long:   Longitude of the location to display
   //             These may be obtained by visiting the URL:
   //                http://www.hmmm.ip3.co.uk/longitude-latitude
   //    $zoom:   The zoom level between 0 (minimum zoom) and
   //             19 (maximum zoom)
   //    $style:  One of Aerial or Road (exact spelling required)
   //    $width:  Width of map
   //    $height: Height of map

   if ($style != 'Aerial' && $style != 'Road') $style = 'Road';

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
