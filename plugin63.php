<?php // 插件63：验证数据库中的用户信息

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
$salt1  = "F^&";
$salt2  = "9*hz!";
$handle = 'firstprez';
$pass   = 'GW022231';

$result = DOPHP_VerifyUserInDB($table, $salt1, $salt2,
   $handle, $pass);
   
if ($result) echo "Login details $handle/$pass verified.";
else echo "Login details $handle/$pass could not be verified.";

$pass = 'GW022232';
echo "<br /><br />";

$result = DOPHP_VerifyUserInDB($table, $salt1, $salt2,
   $handle, $pass);
   
if ($result) echo "Login details $handle/$pass verified.";
else echo "Login details $handle/$pass could not be verified.";

function DOPHP_VerifyUserInDB($table, $salt1, $salt2,
   $handle, $pass)
{
/*
 * 插件说明：
 * 插件把用户提供的用户名和口令与保存在数据库里的用户名和口令进行比较。如果两者一致，则返回TRUE，否则返回FALSE。
 * 它需要以下参数：
 * $table 数据库中的表名
 * $salt1 提供给DOPHP_AddUserToDB()的第一个salt
 * $salt2 第二个salt
 * $handle 输入的用户名。
 * $pass 用户的口令。
 */

   $result = DOPHP_GetUserFromDB($table, $handle);
   if ($result[0] == FALSE) return FALSE;
   elseif ($result[1][2] == md5($salt1 . $pass . $salt2))
      return TRUE;
   else return FALSE;
}

// The plug-in below is included here to ensure that it is
// available to the main plug-in which relies on it

function DOPHP_GetUserFromDB($table, $handle)
{
   $query  = "SELECT * FROM $table WHERE handle='$handle'";
   $result = mysql_query($query);
   if (mysql_num_rows($result) == 0) return array(FALSE);
   else return array(TRUE, mysql_fetch_array($result, MYSQL_NUM));
}

?>
