<?php

/*
 *插件说明：
 *本插件不需要任何参数，若操作成功，则返回一个XMLHttpRequest对象，否则返回false
*/
?>
<script type="text/JavaScript">
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
</script>
