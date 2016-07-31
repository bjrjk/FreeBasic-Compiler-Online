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
return $cip;
}

function Make_Text($dir_path,$pass,$code){
	$ip=GetIP();
	$ua=$_SERVER['HTTP_USER_AGENT'];
	$file=fopen($dir_path.$pass.".txt","w");
	fwrite($file,"Client IP Address:".$ip."\nUser Agent:".$ua."\nCode:\n");
	fwrite($file,$code);
	fwrite($file,"\n----End of File----\nCurrent Time:".date('y-m-d h:i:s',time()));
	fclose($file);
}


$code=$_POST["code"];
$pass=randstr();
if(stripos($code,"shell")!=false||stripos($code,"open")!=false||stripos($code,"exec")!=false){
	Make_Text("shell/failed/",$pass,$code);
	die("Don't do bad things!Recorded!");
}
$file=fopen("code/".$pass.".bas","w");
fwrite($file,$code);
fclose($file);
sleep(2);
$arr=array();
if(!($result=exec("app/".$pass,$arr))){
	$result="Compile Error!";
	Make_Text("error/",$pass,$code);
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