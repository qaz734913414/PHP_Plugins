<?php // 插件45：使用短地址

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$token  = "f8c52"; // Replace with a token from Plug-in 44
$file   = "shorturls.txt";
$result = DOPHP_UseShortURL($token, $file);

if ($result)
{
   echo "The short token '$token' redirects to: ";
   echo "<a href='$result'>$result</a><br /><br />";
   echo "To automatically redirect there do not echo ";
   echo "anything, just output the result returned by ";
   echo "this function in a header, like this:<br /><br />";
   echo '<font face="Courier New">header("Location: $result");';
}
else echo "The short token '$token' is unrecognized";

// To turn this Plug-in into a program to redirect short URLs,
// delete the above example code and replace it with the four
// lines of code below, then save this file as, for example,
// go.php.
   
// $file   = "shorturls.txt";
// $result = DOPHP_UseShortURL($_GET['u'], $file);
// if ($result) header("Location: $result");
// else echo "That short URL is unrecognized";

function DOPHP_UseShortURL($token, $file)
{
/*
插件说明：
本插件接受一个短地址，返回相应的URL长地址。他需要以下参数：
$token 短地址，根据它找到相应的长地址。
$file 插件45用到的数据文件
shorturls.txt内容：
*/

   $contents = @file_get_contents($file);
   $lines    = explode("\n", $contents);
   $shorts   = array();
   $longs    = array();

   if (strlen($contents))
      foreach ($lines as $line)
         if (strlen($line))
            list($shorts[], $longs[]) = explode('|', $line);

   if (in_array($token, $shorts))
      for ($j = 0 ; $j < count($longs) ; ++$j)
         if ($shorts[$j] == $token)
            return $longs[$j];

   return FALSE;
}

?>
