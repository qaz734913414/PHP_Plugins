<?php // 插件61：在数据库中添加用户

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$dbhost = 'localhost'; // Normally no need to change this
$dbname = 'DOPHP';     // Change to your database name
$dbuser = 'root';   // Change to your database user name
$dbpass = '52mysql1314';   // Change to your database password

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

$table  = 'Users';
$nmax   = 32;
$hmax   = 16;
$name   = "Jacky Steven";
$handle = "higher";
$pass   = "high560";
$email  = "admin@4u4v.com";
$salt1  = "F^&";
$salt2  = "9*hz!";

$result = DOPHP_AddUserToDB($table, $nmax, $hmax, $salt1, $salt2, $name, $handle, $pass, $email);

if ($result == -2) echo "The handle '$handle' already exists.";
elseif ($result == 1) echo "User '$name' successfully added.";
else echo "Failed to add user '$name'.";

echo "<br /><br />";
   
$result = DOPHP_AddUserToDB($table, $nmax, $hmax, $salt1, $salt2, $name, $handle, $pass, $email);

if ($result == -2) echo "The handle '$handle' already exists.";
elseif ($result == 1) echo "User '$name' successfully added.";
else echo "Failed to add user '$name'.";

function DOPHP_AddUserToDB($table, $nmax, $hmax, $salt1, $salt2, $name, $handle, $pass, $email)
{
/*
 * 插件说明：
 * 在数据库中添加用户
 * 把一个记录添加到一个MySql数据库里。如果还没建立数据库表，则先创建一个数据库表。
 * 插入成功，则返回值1.
 * 插入失败。则返回-1.
 * 如果这个记录已经存在，返回-2.
 * 它需要以下参数：
 * $table 数据表名。
 * $nmax $name(用户姓名)允许的最大长度。
 * $hmax $handle（用户名）允许的最大长度。
 * $salt1 为了保护口令的安全，用伪随机方法生成一个字符串
 * $salt2 与$salt1一起使用的第二个字符串
 * $name 添加到数据库的用户的全名。
 * $handle 用户名
 * $pass 用户口令
 * $email 用户email地址
 */

   $query = "CREATE TABLE IF NOT EXISTS $table(" .
            "name VARCHAR($nmax), handle VARCHAR($hmax), " .
            "pass CHAR(32), email VARCHAR(256), " .
            "INDEX(name(6)), INDEX(handle(6)), " .
            "INDEX(email(6)))";
   mysql_query($query) or die(mysql_error());

   $query = "SELECT * FROM $table WHERE handle='$handle'";
   if (mysql_num_rows(mysql_query($query)) == 1) return -2;

   $pass  = md5($salt1 . $pass . $salt2);
   $query = "INSERT INTO $table VALUES('$name', '$handle', " .
            "'$pass', '$email')";
   if (mysql_query($query)) return 1;
   else return -1;
}

?>
