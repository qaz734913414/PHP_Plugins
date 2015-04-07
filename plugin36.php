<?php // 插件36：验证Email地址

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$email  = "paul.smith@smithandson.com";
$result = DOPHP_ValidateEmail($email);
echo "The email address: '$email' ";
echo $result ? "validates" : "does not validate";

$email  = "jdoe@usacom";
$result = DOPHP_ValidateEmail($email);
echo "<br />The email address: '$email' ";
echo $result ? "validates" : "does not validate";

function DOPHP_ValidateEmail($email)
{
/*
插件说明：
插件接受一个需要验证格式的email地址，验证成功返回TRUE，否则返回FALSE。
需要参数：
$email：需要验证的email地址
*/
   
   $at = strrpos($email, '@');
   
   if (!$at || strlen($email) < 6) return FALSE;
   
   $left  = substr($email, 0, $at);
   $right = substr($email, $at + 1);
   $res1  = DOPHP_ValidateText($left,  1, 64,  "\w\.\+\-",
      "a");
   $res2  = DOPHP_ValidateText($right, 1, 255, "\a-zA-Z0-9\.\-",
      "a");
  
   if (!strpos($right, '.') || !$res1[0] || !$res2[0])
      return FALSE;
   else return TRUE;
}


function DOPHP_ValidateText($text, $minlength, $maxlength,
   $allowed, $required)
{

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
