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

function cutstr($str,$cutleng)
{
$str = $str; 
$cutleng = $cutleng; 
$strleng = strlen($str); 
if($cutleng>$strleng)return $str;
$notchinanum = 0;
for($i=0;$i<$cutleng;$i++)
{
if(ord(substr($str,$i,1))<=128)
{
$notchinanum++;
}
}
if(($cutleng%2==1)&&($notchinanum%2==0))
{
$cutleng++;
}
if(($cutleng%2==0)&&($notchinanum%2==1))
{
$cutleng++;
}
$str = substr($str,0,$cutleng);
return $str;
}

$code=cutstr($_POST["code"],2048);
$pass=randstr();
if(stripos($code,"shell")!=false||stripos($code,"open")!=false||stripos($code,"exec")!=false||stripos($code,"chain")!=false||stripos($code,"run")!=false||stripos($code,"php")!=false){
	Make_Text("shell/failed/",$pass,$code);
	die("Don't do bad things!Recorded!");
}
$file=fopen("code/".$pass.".bas","w");
fwrite($file,$code);
fclose($file);
sleep(2);
$flag=false;
if(!file_exists("app/".$pass)){
	$result="Compile Error!";
	$ErrInfo="\nDetail Infomation:\n";
	$arr=array();
	exec("cat log.txt|grep \"code/".$pass.".bas(\"",$arr);
	foreach($arr as $value){
		$ErrInfo.=$value."\n";
	}
	$result.=$ErrInfo;
	Make_Text("error/",$pass,$code.$ErrInfo);
	$flag=true;
}else{
  exec("app/".$pass." > result/".$pass.".txt &");
  sleep(2);
  if(exec("ps -A|grep ".$pass)&&stripos(exec("ps -A|grep ".$pass),"defunct")!=true){
	  $flag=true;
  }
  exec("killall ".$pass);
  if(file_exists("result/".$pass.".txt") && $flag==false){
    $result=file_get_contents("result/".$pass.".txt");
  }else{
    $result="Your Program run time over!";
	Make_Text("timeup/",$pass,$code);
  }
}
unlink("app/".$pass);
unlink("result/".$pass.".txt");
echo "<title>FreeBasic Compier Online--Result</title><head><meta name=\"viewport\" content=\"width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no\" /></head><div align=\"center\"><h2>FreeBasic Compier Online--Result</h2>";
if($flag==true){
	echo "<h3>Error File No.<font color=\"red\">$pass</font>.Error Reason is in the following box.For further infomation please contact administrator.</h3>";
}
echo "<p>Code:</p><textarea rows=10 width=75%>$code</textarea><p>Result:</p><textarea rows=10 width=75%>$result</textarea>";
echo "<br/><input type=\"button\" name=\"Submit\" onclick=\"javascript:history.back(-1);\" value=\"Back\"></div>";
?>
