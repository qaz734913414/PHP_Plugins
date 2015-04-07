<?php // 插件62：从表中读取信息

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
$handle = 'higher';

$result = DOPHP_GetUserFromDB($table, $handle);

echo "<pre>";
if ($result[0] == FALSE) echo "Lookup failed.";
else echo "Name         = " . $result[1][0] . "<br />" .
          "Handle       = " . $result[1][1] . "<br />" .
          "Pass(salted) = " . $result[1][2] . "<br />" .
          "Email        = " . $result[1][3];

function DOPHP_GetUserFromDB($table, $handle)
{
/*
 * 插件说明：
 * 根据提供的表名和用户名，插件将读取这个用户的记录并返回给调用程序。
 * 若操作成功，则返回一个两元素的数组，其中第一个元素的值为TRUE,而第二个元素是一个数组，保存用户的各项数据。
 * 若操作失败，则返回一个元素数组，这个元素的值为FALSE.
 * 他需要的参数：
 * $table 数据表名。
 * $handle 用户名。
 */

   $query  = "SELECT * FROM $table WHERE handle='$handle'";
   $result = mysql_query($query);
   if (mysql_num_rows($result) == 0) return array(FALSE);
   else return array(TRUE, mysql_fetch_array($result, MYSQL_NUM));
}

?>
