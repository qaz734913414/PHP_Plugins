<?php // 插件88：输入提示

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

$value = '';

if (isset($_POST['uname']))
{
   $value = $_POST['uname'];
   echo "You submitted the value '$value'<br />";
}

$self = $_SERVER['PHP_SELF'];
echo    "<br /><form method='post' action='$self'>\n";
echo    "Username: " . DOPHP_InputPrompt(
        "name='uname' type='text' size='50' value='$value'",
        'Required Field: Please enter your Username here');
echo    "<input type='submit'></form>\n";

function DOPHP_InputPrompt($params, $prompt)
{


   $id = 'DOPHP_IP_' . rand(0, 1000000);

   $out = <<<_END
<input id='$id' $params
   onFocus="DOPHP_JS_IP1('$id', '$prompt')"
   onBlur="DOPHP_JS_IP2('$id', '$prompt')" />
_END;

   static $DOPHP_IP_NUM;
   if ($DOPHP_IP_NUM++ == 0) $out .= <<<_END
<script>
DOPHP_JS_IP2('$id', '$prompt')

function DOPHP_JS_IP1(id, prompt)
{
   if ($(id).value == prompt) $(id).value = ""
}

function DOPHP_JS_IP2(id, prompt)
{
   if ($(id).value == "") $(id).value = prompt
}

function $(id)
{
   return document.getElementById(id)
}
</script>
_END;
   return $out;
}

?>
