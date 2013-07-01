<?php // go.php

$file   = "shorturls.txt";
$result = DOPHP_UseShortURL($_GET['u'], $file);
if ($result) header("Location: $result");
else echo "That short URL is unrecognized";

function DOPHP_UseShortURL($token, $file)
{
   // Plug-in 45: Use Short URL
   //
   // This plug-in takes a short tail string as created by
   // Plug-in 44 and returns the original long URL. The
   // arguments required are:
   //
   //    $token: A short tail as supplied by Plug-in 44
   //    $file:  Location of a file containing the data
   //            for the redirects.

   $contents = @file_get_contents($file);
   $lines    = explode("\n", $contents);
   $shorts   = array();
   $longs    = array();

   if (strlen($contents))
      foreach ($lines as $line)
         if (strlen($line))
            list($shorts[], $longs[]) = explode('|', $line);

   if (in_array($token, $shorts))
      for ($j = 0 ; $j < count($longs) ; ++$j)
         if ($shorts[$j] == $token)
            return $longs[$j];

   return FALSE;
}

?>