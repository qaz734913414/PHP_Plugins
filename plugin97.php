<?php // 插件97：Google 翻译

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

$text = "We hold these truths to be self-evident, that all " .
        "men are created equal, that they are endowed by " .
        "their creator with certain unalienable rights, that " .
        "among these are life, liberty and the pursuit of " .
        "happiness. That to secure these rights, governments " .
        "are instituted among men, deriving their just powers " .
        "from the consent of the governed.";
$from = 'English';
$to   = 'simplified chinese';

echo "<b>Original</b>: $text<br /><br />";
echo "<i>Translated from $from to $to:</i><br /><br />";

$result = DOPHP_GoogleTranslate($text, $from, $to);
if (!$result) echo "Translation failed.";
else echo "<b>Translation</b>: $result";

function DOPHP_GoogleTranslate($text, $lang1, $lang2)
{
/*
* Google翻译
* 插件说明：
* 插件接受一个字符串，把它从一种语言翻译到另一种语言。
* 若操作成功，则返回译文，否则返回FALSE。
* 它需要以下参数：
* $text 需要翻译的文本
* $lang1 源语言
* $lang2 目标语言
*/

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
   
   if (!isset($langs[$lang1]) || !isset($langs[$lang2]))
      return FALSE;

   $json = @file_get_contents($url . urlencode($text) .
           '&langpair='. $langs[$lang1] . '%7C' .
           $langs[$lang2]);

   if (!strlen($json)) return FALSE;
   
   $result = json_decode($json);
   return $result->responseData->translatedText;
 }

?>
