<?php // 插件11：上传文件 .

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

echo <<<FORM
<form method="post"  action="$_SERVER[PHP_SELF]" enctype="multipart/form-data">
<input  type="hidden"  name="flag" value="1" />
<input  type="file"    name="test" />
<input  type="submit" value="Upload" /></form>
FORM;

if (isset($_POST['flag']))
{
   $result = DOPHP_UploadFile("test",
      array("image/jpeg", "image/pjpeg"), 100000);
   if ($result[0] == 0)
   {
      file_put_contents("test.jpg", $result[2]);
      echo "文件上传成功！";
      echo "查看图片：<a href='test.jpg'>test.jpg</a><br />";
   }
   else
   {
      if ($result[0] == -2) echo "错误的文件类型<br />";
      if ($result[0] == -3) echo "文件超出限定大小<br />";
      if ($result[0] > 0)   echo "Error code: $result<br />";
      echo "文件上传失败！<br />";
   }
}

function DOPHP_UploadFile($name, $filetypes, $maxlen)
{
/*
插件说明：
插件11接受一个表单域的名称，利用这个表单域把文件上传到web服务器，并返回这个上床文件名，上传成功后，发返回一个两元素的数组，第一个元素的值为0，第二个元素是上传的文件名。上传失败时，返回只有一个元素的数组，这个元素的值科恩那个是一下值之一：
“-1” 代表上传失败；
“-2” 代表文件类型错误；
“-3” 代表文件太大；
“1“ 代表文件大小超过php.ini文件中upload_max_filesize参数规定的大小；
”2“ 代表文件大小出熬过HTML表单中MAX_FILE_SIZE指令规定的最大值；
”3“ 代表文件只部分上传；
”4“ 代表没有文件上传；
”6“ 代表PHP没有临时文件夹；
”7“ 代表无法把上传文件保存到磁盘里；
”8“ 代表由于扩展名的原因，文件的上传被中止。
本插件需要以下参数：
$name 代表表单域中输入的上传文件名。
$filetype 数组，包含了受支持的文件类型（mime).
$maxlen 整数，表示上传文件的最大值。
*/
   
   if (!isset($_FILES[$name]['name']))
      return array(-1, NULL, NULL);

   if (!in_array($_FILES[$name]['type'], $filetypes))
      return array(-2, NULL, NULL);
 
   if ($_FILES[$name]['size'] > $maxlen)
      return array(-3, NULL, NULL);

   if ($_FILES[$name]['error'] > 0)
      return array($_FILES[$name]['error'], NULL, NULL);
      
   $temp = file_get_contents($_FILES[$name]['tmp_name']);
   return array(0, $_FILES[$name]['type'], $temp);
}

?>