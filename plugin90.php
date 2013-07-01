<?php // 插件90：预测单词

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo "<form method='post'>";
echo DOPHP_PredictWord("name='word' type='text'", 5, 20);
echo "<input type='submit'></form>\n";

function DOPHP_PredictWord($params, $view, $max)
{
/*
插件说明：
首先建立一个HTML和Javascript代码。这个代码根据用户已经输入的字母，提供一个以这个字母开头的单词或短语选择列表。它需要以下参数：
$params 包括“name=" "type=", "rows=", "clos=", "name=", "size=", "value="在内的标签需要的参数。
$view 在选择列表中最多可显示的单词或短语个数（如果大于此值，列表会出现滚动条)。
$max 提示单词或短语的最大值。
*/

   $id = rand(0, 1000000);

   $out = "<input id='DOPHP_PWI_$id' $params " .
          "onKeyUp='DOPHP_JS_PredictWord($view, $max, $id)'>" .
          "<br /><select id='DOPHP_PWS_$id' " .
          "style='display:none' />\n";

   for ($j = 0 ; $j < $max ; ++$j)
      $out .= "<option id='DOPHP_PWO_$j" . "_$id' " .
              "onClick='DOPHP_JS_CopyWord(this.id, $id)'>";

   $out .= '</select>';
   static $DOPHP_PW_NUM;
   if ($DOPHP_PW_NUM++ == 0) $out .= <<<_END
<script>

function DOPHP_JS_CopyWord(id1, id2)
{
   $('DOPHP_PWI_' + id2).value = $(id1).innerHTML
   $('DOPHP_PWS_' + id2).style.display = 'none';
}

function DOPHP_JS_PredictWord(view, max, id)
{
   if ($('DOPHP_PWI_' + id).value.length > 0)
   {
      DOPHP_JS_GetAjaxRequest2('wordsfromroot.php',
         'word=' + $('DOPHP_PWI_' + id).value +
         '&max=' + max, view, max, id)
      $('DOPHP_PWS_' + id).scrollTop = 0
      $('DOPHP_PWO_0_' + id).selected = true
   }
   else $('DOPHP_PWS_' + id).style.display = 'none'
}

function DOPHP_JS_GetAjaxRequest2(url, params, view, max, id)
{
   nocache = "&nocache=" + Math.random() * 1000000
   request = new DOPHP_JS_AjaxRequest()
   
	request.onreadystatechange = function()
   {
      if (this.readyState == 4)
         if (this.status == 200)
            if (this.responseText != null)
            {
               a = this.responseText.split('|')
               c = 0

               for (j in a)
               {
                  $('DOPHP_PWO_' + c + '_' + id).
                     innerHTML = a[j]
                  $('DOPHP_PWO_' + c++ + '_' + id).
                     style.display = 'block'
               }

               n = c > view ? view : c
               while (c < max)
               {
                  $('DOPHP_PWO_' + c++ + '_' + id).
                     style.display = 'none'
               }
               $('DOPHP_PWS_' + id).size = n;
               $('DOPHP_PWS_' + id).style.display = 'block'
            }

// You can remove these two alerts after debugging
            else alert("Ajax error: No data received")
         else alert( "Ajax error: " + this.statusText)
   }

   request.open("GET", url + "?" + params + nocache, true)
   request.send(null)
}

function DOPHP_JS_AjaxRequest()
{
   try
   {
      var request = new XMLHttpRequest()
   }
   catch(e1)
   {
      try
      {
         request = new ActiveXObject("Msxml2.XMLHTTP")
      }
      catch(e2)
      {
         try
         {
            request = new ActiveXObject("Microsoft.XMLHTTP")
         }
         catch(e3)
         {
            request = false
         }
      }
   }
   return request
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
