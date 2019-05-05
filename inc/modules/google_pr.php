<?
/*
   define('GOOGLE_MAGIC', 0xE6359A60);

   function zeroFill($a, $b)
   {
     $z = hexdec(80000000);
     if($z & $a)
     {
       $a = ($a>>1);
       $a &= (~$z);
       $a |= 0x40000000;
       $a = ($a>>($b-1));
     }
     else { $a = ($a>>$b); }
     return $a;
   }

   function mix($a,$b,$c) 
   {
     $a -= $b; $a -= $c; $a ^= (zeroFill($c,13));
     $b -= $c; $b -= $a; $b ^= ($a<<8);
     $c -= $a; $c -= $b; $c ^= (zeroFill($b,13));
     $a -= $b; $a -= $c; $a ^= (zeroFill($c,12));
     $b -= $c; $b -= $a; $b ^= ($a<<16);
     $c -= $a; $c -= $b; $c ^= (zeroFill($b,5));
     $a -= $b; $a -= $c; $a ^= (zeroFill($c,3));
     $b -= $c; $b -= $a; $b ^= ($a<<10);
     $c -= $a; $c -= $b; $c ^= (zeroFill($b,15));
     return array($a,$b,$c);
   }

   function GoogleCH($urlpage, $length=null, $init=GOOGLE_MAGIC) 
   {
     if(is_null($length)) { $length = sizeof($urlpage); }
     $a = $b = 0x9E3779B9;
     $c = $init;
     $k = 0;
     $len = $length;
     while($len >= 12) 
     {
       $a += ($urlpage[$k+0] + ($urlpage[$k+1]<<8) + ($urlpage[$k+2]<<16) + ($urlpage[$k+3]<<24));
       $b += ($urlpage[$k+4] + ($urlpage[$k+5]<<8) + ($urlpage[$k+6]<<16) + ($urlpage[$k+7]<<24));
       $c += ($urlpage[$k+8] + ($urlpage[$k+9]<<8) + ($urlpage[$k+10]<<16)+ ($urlpage[$k+11]<<24));
       $mix = mix($a,$b,$c);
       $a = $mix[0]; $b = $mix[1]; $c = $mix[2];
       $k += 12;
       $len -= 12;
     }
     $c += $length;
     switch($len)
     {
       case 11: $c+=($urlpage[$k+10]<<24);
       case 10: $c+=($urlpage[$k+9]<<16);
       case 9 : $c+=($urlpage[$k+8]<<8);
       case 8 : $b+=($urlpage[$k+7]<<24);
       case 7 : $b+=($urlpage[$k+6]<<16);
       case 6 : $b+=($urlpage[$k+5]<<8);
       case 5 : $b+=($urlpage[$k+4]);
       case 4 : $a+=($urlpage[$k+3]<<24);
       case 3 : $a+=($urlpage[$k+2]<<16);
       case 2 : $a+=($urlpage[$k+1]<<8);
       case 1 : $a+=($urlpage[$k+0]);
     }
     $mix = mix($a,$b,$c);
     return $mix[2];
   }

   function strord($string) 
   {
     for($i=0;$i<strlen($string);$i++) 
     {
        $result[$i] = ord($string{$i});
     }
     return $result;
   }

// Функция для определения PR Google

   function googleGetPR($url) 
   {
     $urlpage = 'info:'.$url;
     $ch = GoogleCH(strord($urlpage));
     $ch = "6$ch";
     $page = @file("http://www.google.com/search?client=navclient-auto&ch=$ch&features=Rank&q=info:".urlencode($url));
     $page = @implode("", $page);
     if(preg_match("/Rank_1:(.):(.+?)\n/is", $page, $res)) { return "$res[2]"; }
     else return 0;
   }
*/

define('GMAG', 0xE6359A60);
function nooverflow($a)
{
while ($a<-2147483648)
$a+=2147483648+2147483648;
while ($a>2147483647)
$a-=2147483648+2147483648;
return $a;
}
function zeroFill ($x, $bits)
{
   if ($bits==0) return $x;
   if ($bits==32) return 0;
   $y = ($x & 0x7FFFFFFF) >> $bits;
   if (0x80000000 & $x) {
       $y |= (1<<(31-$bits));
   }
   return $y;
}
function mix($a,$b,$c) {
$a=(int)$a; $b=(int)$b; $c=(int)$c;
$a -= $b; $a -= $c; $a=nooverflow($a); $a ^= (zeroFill($c,13));
$b -= $c; $b -= $a; $b=nooverflow($b); $b ^= ($a<<8);
$c -= $a; $c -= $b; $c=nooverflow($c); $c ^= (zeroFill($b,13));
$a -= $b; $a -= $c; $a=nooverflow($a); $a ^= (zeroFill($c,12));
$b -= $c; $b -= $a; $b=nooverflow($b); $b ^= ($a<<16);
$c -= $a; $c -= $b; $c=nooverflow($c); $c ^= (zeroFill($b,5));
$a -= $b; $a -= $c; $a=nooverflow($a); $a ^= (zeroFill($c,3));
$b -= $c; $b -= $a; $b=nooverflow($b); $b ^= ($a<<10);
$c -= $a; $c -= $b; $c=nooverflow($c); $c ^= (zeroFill($b,15));
return array($a,$b,$c);
}
function GCH($url, $length=null, $init=GMAG) {
    if(is_null($length))
    {
        $length = sizeof($url);
    }
    $a = $b = 0x9E3779B9;
    $c = $init;
    $k = 0;
    $len = $length;
    while($len >= 12)
    {
        $a += ($url[$k+0] +($url[$k+1]<<8) +($url[$k+2]<<16) +($url[$k+3]<<24));
        $b += ($url[$k+4] +($url[$k+5]<<8) +($url[$k+6]<<16) +($url[$k+7]<<24));
        $c += ($url[$k+8] +($url[$k+9]<<8) +($url[$k+10]<<16)+($url[$k+11]<<24));
        $mix = mix($a,$b,$c);
        $a = $mix[0]; $b = $mix[1]; $c = $mix[2];
        $k += 12;
        $len -= 12;
    }
    $c += $length;
    switch($len)
    {
        case 11: $c+=($url[$k+10]<<24);
        case 10: $c+=($url[$k+9]<<16);
        case 9 : $c+=($url[$k+8]<<8);
        case 8 : $b+=($url[$k+7]<<24);
        case 7 : $b+=($url[$k+6]<<16);
        case 6 : $b+=($url[$k+5]<<8);
        case 5 : $b+=($url[$k+4]);
        case 4 : $a+=($url[$k+3]<<24);
        case 3 : $a+=($url[$k+2]<<16);
        case 2 : $a+=($url[$k+1]<<8);
        case 1 : $a+=($url[$k+0]);
    }
    $mix = mix($a,$b,$c);
    return $mix[2];
}
function strord($string)
{
    for($i=0;$i<strlen($string);$i++)
    {
        $result[$i] = ord($string{$i});
    }
    return $result;
}

function google_pr($params)
{
	$aUrl = $params["url"];
    $url = 'info:'.$aUrl;
    $ch = GCH(strord($url));
    $url='info:'.urlencode($aUrl);
    $pr = @file("http://www.google.com/search?client=navclient-auto&ch=6$ch&ie=UTF-8&oe=UTF-8&features=Rank&q=$url");
    $pr_str = @implode("", $pr);
    //print $pr_str;
    //$pr = substr($pr_str,strrpos($pr_str, ":")+1);
    //$pr = ($pr!="" || $pr!=" ")?'x':$pr;
		if(preg_match("/Rank_1:(.):(.+?)\n/is", $pr_str, $res))
		{
			$rez = $res[2];
		}
    else 
    {
    	$rez = 'x';
    }
	$outAr["value"] = $rez;
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = '';
	return $outAr;
} 

?>