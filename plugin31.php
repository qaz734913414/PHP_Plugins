<?php // 插件31：表达式求值

/***************
 *Owner: 水木
 *Licence: GPL
 *Description:
 *PHP功能插件开发应用
 *Blog: shuimu.js.cn
 *Email: admin@4u4v.net
 **********************/

echo "<font face='Courier New'><pre>";
$s = "TAN(64)";
echo "$s\t\t\t= " . DOPHP_EvaluateExpression($s) . "\n";
$s = "sqrt(77.3) / 99";
echo "$s\t\t= "   . DOPHP_EvaluateExpression($s) . "\n";
$s = "1 + 2 / 3 * 4 - 5";
echo "$s\t= "     . DOPHP_EvaluateExpression($s) . "\n";
$s = "log(100)";
echo "$s\t\t= "   . DOPHP_EvaluateExpression($s) . "\n";
$s = "pi()";
echo "$s\t\t\t= " . DOPHP_EvaluateExpression($s) . "\n";

function DOPHP_EvaluateExpression($expr)
{
/*
插件说明：
插件接受一个表示数学表达式的字符串，并返回这个表达式的结果，它需要参数：
$expr 一个包含数学表达式的字符串
*/  
   $f1 = array ('abs',   'acos',  'acosh', 'asin',  'asinh',
                'atan',  'atan2', 'atanh', 'cos',   'cosh',
                'exp',   'expm1', 'log',   'log10', 'log1p',
                'pi',    'pow',   'sin',   'sinh',  'sqrt',
                'tan',   'tanh');

   $f2 = array ('!01!',  '!02!',  '!03!',  '!04!',  '!05!',
                '!06!',  '!07!',  '!08!',  '!09!',  '!10!',
                '!11!',  '!12!',  '!13!',  '!14!',  '!15!',
                '!16!',  '!17!',  '!18!',  '!19!',  '!20!',
                '!21!',  '!22!');

   $expr = strtolower($expr);
   $expr = str_replace($f1, $f2, $expr);
   $expr = preg_replace("/[^\d\+\*\/\-\.(),! ]/", '', $expr);
   $expr = str_replace($f2, $f1, $expr);

   // Uncomment the line below to see the sanitized expression
   // echo "$expr<br />\n";

   return eval("return $expr;");
}

?>
