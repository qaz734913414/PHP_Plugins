<html><head>
<title>AJAX POST Example</title>
</head>
<body>
<!--
插件说明：
本插件接受一个网页的URL地址，若个参数和一个文档对象模型（DOM）。把操作结果插入到这个DOM对象中，他不返回任何参数。如果操作成功，则把Web服务器传回的结果插入到DOM对象里。如果操作失败，则出现一个警告窗口，帮助我们调试程序。在产生型网站上，可能禁止此功能。本插件需要以下参数：
·1.URL: 需要调用的网页或程序。
2.params：Post参数，又“&”符号分隔，如var1=value1&var2=value2.
3.target:接受调用结果的DOM元素。
 -->
<h1>Loading a page in-between <font face='Courier New'>&lt;div&gt;&hellip;&lt;/div&gt;</font> tags</h1>
<div id='info'>The contents of this DIV will be replaced</div>

<script type="text/javascript">

DOPHP_JS_PostAjaxRequest('ajaxpost.php',
   'url=http://www.qq.com/',
   document.getElementById('info'))

function DOPHP_JS_PostAjaxRequest(url, params, target)
{
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

   request.open("POST", url, true)
   request.setRequestHeader("Content-type",
      "application/x-www-form-urlencoded")
   request.setRequestHeader("Content-length",
      params.length)
   request.setRequestHeader("Connection", "close")
   request.send(params)
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
