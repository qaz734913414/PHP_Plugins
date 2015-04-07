<?php // 插件64：“消毒”字符串MySQL“消毒”字符串

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

$string = "& This is an 'example' string to be <b>sanitized</b><script>alert('warning');</script>";

echo "DOPHP_SanitizeString()<xmp>";
echo "Before: " . $string . "\n";
echo "After:  " . DOPHP_SanitizeString($string);
echo "</xmp>";

$dbhost = 'localhost'; // Normally no need to change this
$dbname = 'DOPHP';     // Change to your database name
$dbuser = 'root';   // Change to your database user name
$dbpass = '52mysql1314';   // Change to your database password

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());

echo "DOPHP_MySQLSanitizeString()<xmp>";
echo "Before: " . $string . "\n";
echo "After:  " . DOPHP_MySQLSanitizeString($string);
echo "</xmp>";

function DOPHP_SanitizeString($string)
{
   // Plug-in 64a: Sanitize String
   //
   // This plug-in accepts a string, which then has any
   // potentially malicious characters removed from it.
   // It expects this argument:
   //
   //    $string: The string to sanitize

	$string = strip_tags($string);
	return htmlentities($string);
}
/*
 * 插件说明：
 * 阻止任何可能攻击服务器的意图，或者防止插入一些不需要的MySql命令、HTML语句或者Javascript脚本。
 * 插件的连个函数接受一个字符串，对它进行"消毒"处理后，就可以用在自己的网站上或MySql数据库里。
 * 他们都需要一个参数：
 * $string 一个需要"消毒"处理的字符串。
 */
function DOPHP_MySQLSanitizeString($string)
{
   // Plug-in 64b: MySQL Sanitize String
   //
   // This plug-in accepts a string, which then has any
   // potentially malicious characters removed from it.
   // This includes any characters that could be used to
   // try and compromise a MySQL database. Only call
   // this once a connection has been opened to a MySQL
   // database, otherwise an error will occur. It expects
   // this argument:
   //
   //    $string: The string to sanitize

   if (get_magic_quotes_gpc())
      $string = stripslashes($string);
	$string = DOPHP_SanitizeString($string);
   return mysql_real_escape_string($string);
}

?>
