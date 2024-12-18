<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 ini_set('default_charset','UTF-8');

class Get_Date {
 //for encode 
 
public function adate($format='_j _M _Yهـ',$timestamp=0)
 {
$gmonths=array("يناير","فبراير","مارس","أبريل","مايو","يونيو","يوليو","أغسطس","سبتمبر","أكتوبر","نوفمبر","ديسمبر");
$smonths=array("كانون الثاني","شباط","آذار","نيسان","أيار","حزيران","تموز","آب","أيلول","تشرين الأول","تشرين الثاني","كانون الأول");
$days=array("الأحد","الإثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت");
$hmonths=array("محرم","صفر","شهر ربيع الأول","شهر ربيع الثاني","جمادى الأولى","جمادى الآخرة","رجب","شعبان","شهر رمضان","شوال","ذو القعدة","ذو الحجة");

if ($timestamp==0) {$timestamp=time();}
list($w, $mn,$am)=explode(' ', date("w n a",$timestamp));
$j=intval($timestamp/86400);
$j=$j+492150; //492534;
$n = intval($j / 10631);
$j=$j-($n*10631);
$y = intval($j / 354.36667);
$hy = ($n*30)+$y+1;
$j=$j-round($y*354.36667);
$z=$j;
$m = intval($j/29.5);
$hm = $m+1;
$j=$j-round($m*29.5);
$d = $j;
$hd = intval($d-1);

If ($hd == 0) {
$hd=($hm%2==1)? (29): (30);
$hm = $hm - 1;
}

If ($hm == 0 ) {
$hm = 12;
$hy = $hy - 1;
if (round(($hy%30)*0.36667)>round((($hy-1)%30)*0.36667)) {
    $hd=30;
    $z=355;
    } else {
        $hd=29;
        $z=354;
    }
}
$L=(round(($hy%30)*0.36667)>round((($hy-1)%30)*0.36667))?(1):(0);
$str='';
for ($n=0;$n<=strlen($format);$n++) {
    $c=substr($format,$n,1);
switch ($c) {
    case "l":
    case "D":
    $str.=$days[$w];
    break;
    case "F":
    $str.=$smonths[($mn-1)];
    break;
    case "M":
    $str.=$gmonths[($mn-1)];
    break;
    case "a":
    $str.=($am=='am')? ('ص'):('م');
    break;
    case "A":
    $str.=($am=='AM')? ('صباحًا'):('مساءً');
    break;
    case "_":
        $n=$n+1;
        switch (substr($format,$n,1)) {
            case "j":
            $str.=$hd;
            break;
            case "d":
            $str.=str_pad($hd,2,"0",STR_PAD_LEFT);
            break;
            case "z":
            $str.=$z-1;
            break;
            case "F":case "M":
            $str.=$hmonths[($hm-1)];
            break;
            case "t":
            $t=($hm%2==1)? (30): (29);
            If ($hm == 12 && $L==1) $t =30;
            $str.=$t;
            break;
            case "m":
            $str.=str_pad($hm,2,"0",STR_PAD_LEFT);
            break;
            case "n":
            $str.=$hm;
            break;
            case "y":
            $str.=substr($hy,2);
            break;
            case "Y":
            $str.=$hy;
            break;
            case "L":
            $str.=$L;
            break;
        }    
    break;
    case '\\':
    $str.=substr($format,$n,2);
    $n++;
    break;
    default:
    $str.=$c;
    break;
 }    
    
}
return date($str,$timestamp);
 }
}
 ?>
