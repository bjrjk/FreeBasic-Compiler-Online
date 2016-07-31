<?php

function randstr($len=4) { 
$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
mt_srand((double)microtime()*1000000*getmypid()); 
$password=''; 
while(strlen($password)<$len) 
$password.=substr($chars,(mt_rand()%strlen($chars)),1); 
return $password; 
}

function GetIP(){
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  $cip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
elseif(!empty($_SERVER["REMOTE_ADDR"])){
  $cip = $_SERVER["REMOTE_ADDR"];
}
else{
  $cip = $_SERVER["HTTP_CLIENT_IP"];
}
return $cip;
}

$code=$_POST["code"];
$pass=randstr();
if(stripos($code,"shell")!=false&&stripos($code,"shell_str")==false){
	die("Don't do bad things!");
}
$file=fopen("code/".$pass.".bas","w");
fwrite($file,$code);
fclose($file);
sleep(2);
$arr=array();
if(!($result=exec("app/".$pass,$arr))){
	$result="Compile Error!";
}else{
	$result="";
	foreach($arr as $item){
		$result.=$item."\n";
	}
}
echo "<title>FreeBasic Compier Online--Result</title><div align=\"center\"><h2>FreeBasic Compier Online--Result</h2>";
echo "<p>Code:</p><textarea rows=10 cols=50>$code</textarea><p>Result:</p><textarea rows=10 cols=50>$result</textarea>";
echo "</div>";
?>