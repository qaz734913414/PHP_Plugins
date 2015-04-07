<?php 
/*
插件说明：
插件83接受一个网页的URL地址和传递个网页的参数，以及一个用来保存结果的文档对象模型（DOM）。他不返回任何参数，但是如果操作成功，文档对象模型将保持从Web服务器返回的结果。如果操作失败，则出现一个有利于调试的警告窗口。在生产型网站上，我们可能希望禁用这种调试。他需要以下参数：
1.URL:调用Web页面或程序。
2.params:GET参数，用"&"把各参数分开，如var1=value1&var2=value2。
3. target： DOM元素，用来保存调用返回的结果。
*/
?>
<html><head>
<title>AJAX GET Example</title>
</head><body><center />
<h1>Loading a page in-between <font face='Courier New'><div>…</div></font> tags</h1>
<div id='info'>The contents of this DIV will be replaced</div>

<script type="text/JavaScript">

DOPHP_JS_GetAjaxRequest('ajaxget.php',
   'url=http://amazon.com/mobile',
   document.getElementById('info'))

function DOPHP_JS_GetAjaxRequest(url, params, target)
{
   nocache = "&nocache=" + Math.random() * 1000000
   request = new DOPHP_JS_AjaxRequest()
   
   request.onreadystatechange = function()
   {
      if (this.readyState == 4)
         if (this.status == 200)
            if (this.responseText != null)
               target.innerHTML = this.responseText
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
</script>
