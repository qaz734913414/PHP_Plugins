<?php // 插件73：读取wiki页面

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo '<html><head><meta http-equiv="Content-Type" ' .
     'content="text/html; charset=utf-8" /></head><body>';
echo '<font face="Verdana" size="2">';
echo DOPHP_FetchWikiPage('Climate Change');

function DOPHP_FetchWikiPage($entry)
{
/*
 * 插件说明：
 * 读取wiki页面
 * 插件接受一个维基文章的标题，返回这个文章的文本内容。如果读取失败，返回false.
 * 它需要以下参数：
 * $netry 危及文章的标题
 */

   $agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-GB; ' .
            'rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR ' .
            '3.5.30729)';
   $text = '';

   while ($text == '' || substr($text, 0, 9) == '#REDIRECT')
   {
      $entry = rawurlencode($entry);
      $url   = "http://en.wikipedia.org/wiki/Special:Export/$entry";
      $page  = DOPHP_CurlGetContents($url, $agent);
      $xml   = simplexml_load_string($page);
      $title = $xml->page->title;
      $text  = $xml->page->revision->text;

      if (substr($text, 0, 9) == '#REDIRECT')
      {
         preg_match('/\[\[(.+)\]\]/', $text, $matches);
         $entry = $matches[1];
      }
   }

   $sections = array('References', 'See also', 'External links',
      'Notes', 'Further reading');

   foreach($sections as $section)
   {
      $ptr = stripos($text, "==$section==");
      if ($ptr) $text = substr($text, 0, $ptr);
      $ptr = stripos($text, "== $section ==");
      if ($ptr) $text = substr($text, 0, $ptr);
   }

   $data = array('\[{2}Imag(\[{2})*.*(\]{2})*\]{2}', '',
                 '\[{2}File(\[{2})*.*(\]{2})*\]{2}', '',
                 '\[{2}Cate(\[{2})*.*(\]{2})*\]{2}', '',
                 '\{{2}([^\{\}]+|(?R))*\}{2}',       '',
                 '\'{3}(.*?)\'{3}',         '<b>$1</b>',
                 '\'{2}(.*?)\'{2}',         '<i>$1</i>',
                 '\[{2}[^\|\]]+\|([^\]]*)\]{2}',   '$1',
                 '\[{2}(.*?)\]{2}',                '$1',
                 '\[(http[^\]]+)\]',                ' ',
                 '\n(\*|#)+',   '<br />&nbsp;● ',
                 '\n:.*?\n',                         '', 
                 '\n\{[^\}]+\}',                     '',
                 '\n={7}([^=]+)={7}',     '<h7>$1</h7>',
                 '\n={6}([^=]+)={6}',     '<h6>$1</h6>',
                 '\n={5}([^=]+)={5}',     '<h5>$1</h5>',
                 '\n={4}([^=]+)={4}',     '<h4>$1</h4>',
                 '\n={3}([^=]+)={3}',     '<h3>$1</h3>',
                 '\n={2}([^=]+)={2}',     '<h2>$1</h2>',
                 '\n={1}([^=]+)={1}',     '<h1>$1</h1>',
                 '\n{2}',                         '<p>',
                 '<gallery>([^<]+?)<\/gallery>',     '',
                 '<ref>([^<]+?)<\/ref>',             '',
                 '<ref [^>]+>',                      '');

   for ($j = 0 ; $j < count($data) ; $j += 2)
      $text = preg_replace("/$data[$j]/", $data[$j+1], $text);

   $text  = strip_tags($text, '<h1><h2><h3><h4><h5><h6><h7>' .
                              '<p><br><b><i>');
   $url   = "http://en.wikipedia.org/wiki/$title";
   $text .= "<p>Source: <a href='$url'>Wikipedia ($title)</a>";
   return trim($text);
}

function DOPHP_CurlGetContents($url, $agent)
{
   // Plug-in 72: Curl Get Contents

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
