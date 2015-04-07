<?php // 插件35：文本验证

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$text     = "This is some example text - let's test it!";
$allowed  = "a-zA-Z0-9 ";
$required = "";
$result = DOPHP_ValidateText($text, 1, 30, $allowed, $required);
echo "$text<br /><br />";

if ($result[0] == FALSE)
   for ($j = 0 ; $j < count($result[1]) ; ++$j)
      echo "&nbsp; " . $result[1][$j] . ".<br>";
else echo "&nbsp; Passed evaluation";

$text     = "password";
$allowed  = "a-zA-Z0-9 !&*+=:;@~#";
$required = "ludp";
$result = DOPHP_ValidateText($text, 10, 16, $allowed, $required);
echo "<br />$text<br /><br />";

if ($result[0] == FALSE)
   for ($j = 0 ; $j < count($result[1]) ; ++$j)
      echo "&nbsp; " . $result[1][$j] . ".<br>";
else echo "&nbsp; Passed evaluation";

function DOPHP_ValidateText($text, $minlength, $maxlength,
   $allowed, $required)
{
/*
插件说明：
插件接受一个需要验证的字符串以及有关合法字符和非法字符等详细信息。验证失败则返回一个两元素数组。
其中第一个元素值是FALSE,第二个元素是一个代表错误信息的数组（如果验证通过，则返回一个元素的数组，它的值为TRUE)。具体如下：
$text 需要验证的文本
$minlength 允许的最小长度
$maxlength 允许的最大长度
$allowed 文本中允许出现的字符。他可以是任何字符，如用“a-"表示字符范围，如”a-zA-Z"
$required 必须输入的字符，即他们必须在文本中至少出现一次。他可能取a、1、字母、数字、单词（由字母或数字组成）或标点符号。
*/ 
   $len   = strlen($text);
   $error = array();
   
   if ($len < $minlength)
      $error[] = "The string length is too short " . 
         "(min $minlength characters)";
   elseif ($len > $maxlength)
      $error[] = "The string length is too long " .
         "(max $maxlength characters)";
   
   $result = preg_match_all("/([^$allowed])/", $text, $matches);
   $caught = implode(array_unique($matches[1]), ', ');
   $plural = strlen($caught) > 1 ? $plural = "s are" : " is";

   if ($result) $error[] = "The following character$plural " .
      "not allowed: " . $caught;

   for ($j = 0 ; $j < strlen($required) ; ++$j)
   {
      switch(substr(strtolower($required), $j, 1))
      {
         case "a": $regex = "a-zA-Z"; $str = "letter";
                   break;
         case "l": $regex = "a-z";    $str = "lower case";
                   break;
         case "u": $regex = "A-Z";    $str = "upper case";
                   break;
         case "d": $regex = "0-9";    $str = "digit";
                   break;
         case "w": $regex = "\w";     $str = "letter, number or _";
                   break;
         case "p": $regex = "\W";     $str = "punctuation";
                   break;
      }

      if (!preg_match("/[$regex]/", $text))
         $error[] = "The string must include at least one " .
            "$str character";
   }

   if (count($error)) return array(FALSE, $error);
   else return array(TRUE);
}

?>
