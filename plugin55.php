<?php // 插件55：浏览聊天记录

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: www.4u4v.net
 *Email: admin@4u4v.net
 **********************/

if (!DOPHP_ViewChat('chatroom.txt', 'fredsmith', 300))
   echo "Error. Could not open the chat data file";
else die("<script>self.location='" . $_SERVER['PHP_SELF'] .
   "'</script>");

function DOPHP_ViewChat($datafile, $username, $maxtime)
{
/*
 * 插件说明：
 * 插件接受一个聊天室数据文件，显示当前用户可以浏览的全部聊天记录，可以是密聊内容，也可以是公开的内容。它需要以下参数：
 * $datafile 字符串，表示聊天室数据文件保存的位置。
 * $username 浏览聊天记录的当前用户名。
 * $maxtime 与聊天服务器的最大连接时间，单位为秒。这个参数必须取相当大的值，
 * 防止频繁反复刷新聊天内容，通常取300秒比较合适。
 */
   if (!file_exists($datafile)) return FALSE;

   set_time_limit($maxtime + 5);
   $tn      = time();
   $tstart  = "<table width='100%' border='0'><tr><td " .
              "width='15%' align='right'>";
   $tmiddle = "</td><td width='85%'>";
   $tend    = "</td></tr></table><script>scrollBy(0,1000);" .
              "</script>\n";
   $oldpnum = 0;
   
   while (1)
   {
      $lines = explode("\n",
         rtrim(file_get_contents($datafile)));

      foreach ($lines as $line)
      {
         $thisline = explode("|", $line);
         $postnum  = $thisline[0];
         $to       = $thisline[1];
         $from     = $thisline[2];
         $message  = $thisline[3];

         if ($postnum > $oldpnum)
         {
            if ($to == "")
            {
               echo $tstart . "$from:" . $tmiddle .
                  $message . $tend;
            }
            elseif ($to == $username || $from == $username)
            {
               echo $tstart . "$from:" . $tmiddle .
                  "(PM to $to) <i>$message</i>" . $tend;
            }

            $oldpnum = $postnum;
            ob_flush();
            flush();
         }
      }
      
      sleep(2);
      if ((time() - $tn) > $maxtime) return TRUE;
   }
}

?>
