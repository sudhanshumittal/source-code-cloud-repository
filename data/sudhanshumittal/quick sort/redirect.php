<?php
require './core.inc.php';

if(isset($_POST['username'])){
$username = $_POST['username'];
}else{
$username = "";
}

if(isset($_POST['password'])){
$password = $_POST['password'];
}else{
$password = "";
}
if(isset($_POST['loginServer'])){
$server = $_POST['loginServer'];
$server = $server.".iitg.ernet.in";
}

$link=imap_open("{".$server.":995/pop3/ssl/novalidate-cert}",$username,$password);
if ($link){
                imap_close($link);
				$con = mysql_connect("localhost","root","");
				if (!$con)
				{
					//echo "damn it";
					die('Could not connect: ' . mysql_error());
				}
				mysql_select_db("events", $con);
				 $result = mysql_query("SELECT * FROM members WHERE username ='".$username."'");
				 $num_rows = mysql_num_rows($result);
				 if($num_rows==0){
						mysql_query("INSERT INTO members(username, name, interests, position, getmails)
VALUES ( '".$username."', 'unknown', 'unknown', '1', '1' )");
				// echo "done";
				 }	
				$_SESSION['username'] = $username;
				header('Location:index.php');
}else{
			  header('Location: index.php?&retry=1');
}
?>